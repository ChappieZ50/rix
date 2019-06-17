function simplePost(data, url, type = 'post') {
    return $.ajax({
        type: type,
        url: url,
        data: data,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    });
}
