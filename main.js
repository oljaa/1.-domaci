
function ucitajSelect(putanja, elementId) {
    $.getJSON(putanja, function (res) {
        if (!res.status) {
            alert(res.error);
            return;
        }
        $('#' + elementId).html('');
        for (let element of res.data) {
            $('#' + elementId).append(`
                <option value='${element.id}'>
                    ${element.naziv}
                </option>
            `)
        }
    })
}

function ucitajUTabelu(putanja, elementId, rowRenderer, filter) {

    $.getJSON(putanja, function (res) {
        if (!res.status) {
            alert(res.error);
            return;
        }
        $('#' + elementId).html('');
        for (let element of res.data) {
            if (!filter || filter(element)) {
                $('#' + elementId).append(rowRenderer(element))
            }
        }
    })

}