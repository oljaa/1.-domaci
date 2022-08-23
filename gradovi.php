<?php
include './layout/header.php';
?>

<div class='container mt-2'>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Forma grad</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form id="forma">
                        <div class="form-group">
                            <label for="naziv" class="col-form-label">Naziv</label>
                            <input required type="text" class="form-control" id="naziv">
                        </div>
                        <div class="form-group">
                            <label for="postanskiBroj" class="col-form-label">Postanski broj</label>
                            <input required type="text" class="form-control" id="postanskiBroj">
                        </div>
                        <button type="submit" class="btn btn-primary form-control">Sacuvaj</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div>
        <h1 class='text-center'>
            Gradovi u Srbiji
        </h1>
    </div>
    <div class="d-flex justify-content-end">
        <button data-toggle="modal" data-target="#exampleModal" class="btn btn-primary">Kreiraj grad</button>
    </div>

    <div class="mt-5">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naziv</th>
                    <th>Postanski broj</th>
                    <th>Izmeni</th>
                    <th>Obrisi</th>
                </tr>
            </thead>
            <tbody id='podaci'>

            </tbody>
        </table>
    </div>

</div>
<script src="./main.js"></script>
<script>
    let id = 0;
    $(document).ready(function() {
        ucitaj();
        $('#exampleModal').on('show.bs.modal', function(e) {
            const button = $(e.relatedTarget);
            const selId = button.data('id');
            if (!selId) {
                id = 0;
                return;
            }
            id = selId;
            $('#naziv').val(button.data('naziv'))
            $('#postanskiBroj').val(button.data('postanskibroj'))
        })
        $('#forma').submit(function(e) {
            e.preventDefault();
            const naziv = $('#naziv').val();
            const postanskiBroj = $('#postanskiBroj').val();
            if (!id) {
                $.post('server/grad.php?akcija=kreiraj', {
                    naziv,
                    postanskiBroj
                }, function(res) {
                    res = JSON.parse(res);
                    if (!res.status) {
                        alert(res.error)
                    } else {
                        alert("Uspesno kreiran grad")
                    }
                    ucitaj();
                })
            } else {
                $.post('server/grad.php?akcija=izmeni&id=' + id, {
                    naziv,
                    postanskiBroj
                }, function(res) {
                    res = JSON.parse(res);
                    if (!res.status) {
                        alert(res.error)
                    } else {
                        alert("Uspesno izmenjen grad")
                    }
                    ucitaj();
                })
            }
        })
    })

    function ucitaj() {
        ucitajUTabelu('server/grad.php?akcija=vratiSve', 'podaci', function(element) {
            return `
                <tr>
                    <td>${element.id}</td>
                    <td>${element.naziv}</td>
                    <td>${element.postanskiBroj}</td>
                    <td>
                        <button data-toggle="modal" data-target="#exampleModal" 
                                data-id=${element.id} data-naziv="${element.naziv}" data-postanskibroj="${element.postanskiBroj}" class='btn btn-success form-control'>Izmeni</button>
                    </td>
                    <td>
                        <button onClick="obrisi(${element.id})" class='btn btn-danger form-control'>Obrisi</button>
                    </td>
                </tr>
            `
        });
    }

    function obrisi(id) {
        $.post('server/grad.php?akcija=obrisi&id=' + id, function(res) {
            res = JSON.parse(res);
            if (!res.status) {
                alert(res.error);
            } else {
                alert("Uspesno obrisan grad");
            }
            ucitaj();
        })
    }
</script>
<?php
include './layout/footer.php';
?>