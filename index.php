<?php
include './layout/header.php';
?>
<div class='container mt-2'>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Forma festival</h5>
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
                            <label for="adresa" class="col-form-label">Adresa</label>
                            <input required type="text" class="form-control" id="adresa">
                        </div>
                        <div class="form-group">
                            <label for="grad" class="col-form-label">Grad</label>
                            <select required type="text" class="form-control" id="grad"></select>
                        </div>
                        <div class="form-group">
                            <label for="pocetak" class="col-form-label">Pocetak</label>
                            <input required type="date" class="form-control" id="pocetak">
                        </div>
                        <div class="form-group">
                            <label for="kraj" class="col-form-label">Kraj</label>
                            <input required type="date" class="form-control" id="kraj">
                        </div>

                        <div class="form-group">
                            <label for="tip" class="col-form-label">Tip </label>
                            <select required type="text" class="form-control" id="tip"></select>
                        </div>
                        <div class="form-group">
                            <label for="opis" class="col-form-label">Opis</label>
                            <textarea required type="text" class="form-control" id="opis"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary form-control">Sacuvaj</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <div>
        <h1 class='text-center'>
            Festivali
        </h1>
    </div>
    <div class="d-flex justify-content-end">
        <button data-toggle="modal" data-target="#exampleModal" class="btn btn-primary">Kreiraj festival</button>
    </div>
    <div class="mt-4 mb-4">
        <input class="form-control" type="text" id='pretraga' placeholder="Pretrazi...">
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naziv</th>
                <th>Tip </th>
                <th>Pocetak</th>
                <th>Kraj</th>
                <th>Adresa</th>
                <th>Grad</th>
                <th>Izmeni</th>
                <th>Obrisi</th>
            </tr>
        </thead>
        <tbody id='festivali'>

        </tbody>
    </table>
    <script src="./main.js"></script>
    <script>
        let id = 0;
        $(document).ready(function() {
            ucitajFestivale();
            ucitajSelect('server/grad.php?akcija=vratiSve', 'grad')
            ucitajSelect('server/tipFestivala.php?akcija=vratiSve', 'tip');
            $('#pretraga').change(function() {
                ucitajFestivale();
            });
            $('#forma').submit(function(e) {
                e.preventDefault();
                const naziv = $('#naziv').val();
                const pocetak = $('#pocetak').val();
                const tip = $('#tip').val();
                const kraj = $('#kraj').val();
                const adresa = $('#adresa').val();
                const opis = $('#opis').val();
                const grad = $('#grad').val();
                const telo = {
                    naziv,
                    pocetak,
                    tip,
                    kraj,
                    adresa,
                    opis,
                    grad
                }
                if (id) {
                    $.post('server/festival.php?akcija=izmeni&id=' + id, telo, function(res) {
                        res = JSON.parse(res);
                        if (!res.status) {
                            alert(res.error);
                        } else {
                            alert("Uspesno izmenjen festival");
                        }
                        ucitajFestivale();
                    })
                } else {
                    $.post('server/festival.php?akcija=kreiraj', telo, function(res) {
                        res = JSON.parse(res);
                        if (!res.status) {
                            alert(res.error);
                        } else {
                            alert("Uspesno kreiran festival");
                        }
                        ucitajFestivale();
                    })
                }
            })
            $('#exampleModal').on('show.bs.modal', function(e) {
                const button = $(e.relatedTarget);
                const selId = button.data('id');
                if (!selId) {
                    id = 0;
                    return;
                }
                id = selId;
                $('#naziv').val(button.data('naziv'))
                $('#opis').val(button.data('opis'))
                $('#pocetak').val(button.data('pocetak'))
                $('#kraj').val(button.data('kraj'))
                $('#adresa').val(button.data('adresa'))
                $('#grad').val(button.data('grad'))
                $('#tip').val(button.data('tip'))
            })
        })


        function ucitajFestivale() {
            ucitajUTabelu('server/festival.php?akcija=vratiSve', 'festivali', iscrtajFestival, filtrirajFestivale)
        }

        function iscrtajFestival(element) {
            return `
                <tr>
                    <td>${element.id}</td>
                    <td>${element.naziv}</td>
                    <td>${element.tip.naziv}</td>
                    <td>${element.pocetak}</td>
                    <td>${element.kraj}</td>
                    <td>${element.adresa}</td>
                    <td>${element.grad.naziv}</td>
                    <td>${element.opis}</td>
                    <td>
                        <button data-toggle="modal" data-target="#exampleModal" 
                                data-id=${element.id}
                                data-naziv="${element.naziv}" 
                                data-tip="${element.tip.id}" 
                                data-pocetak="${element.pocetak}"
                                data-kraj="${element.brojTelefona}"
                                data-adresa="${element.adresa}"
                                data-grad="${element.grad.id}"
                                data-opis="${element.opis}"
                                class='btn btn-success form-control'>Izmeni</button>
                    </td>
                    <td>
                        <button onClick="obrisi(${element.id})" class='btn btn-danger form-control'>Obrisi</button>
                    </td>
                </tr>
            `
        }

        function filtrirajFestivale(element) {
            const pretaraga = $('#pretraga').val();
            for (let key in element) {
                if (typeof element[key] !== 'object') {
                    if ((element[key] + '').toLocaleLowerCase().includes(pretaraga.toLocaleLowerCase())) {
                        return true;
                    }
                }

            }
            return false;
        }

        function obrisi(id) {
            $.post('server/festival.php?akcija=obrisi&id=' + id, function(res) {
                res = JSON.parse(res);
                if (!res.status) {
                    alert(res.error);
                } else {
                    alert("Uspesno obrisan festival");
                }
                ucitajFestivale();
            })
        }
    </script>
</div>
<?php
include './layout/footer.php';
?>