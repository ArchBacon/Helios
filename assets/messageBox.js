window.onload = function () {
    let button = document.createElement('button');
    button.setAttribute('id', 'messageButton');
    button.addEventListener('click', openPopup);
    button.style.height = '3em';
    button.style.width = '3em';
    button.style.backgroundColor = 'rgb(234 88 12)';
    button.style.borderRadius = '100%';
    button.style.display = 'flex';
    button.style.justifyContent = 'center';
    button.style.alignItems = 'center';
    button.style.position = 'absolute';
    button.style.bottom = '2.5em';
    button.style.right = '2.5em';
    button.style.color = 'white';
    button.style.border = 'none';
    button.style.cursor = 'pointer';

    let path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
    path.setAttribute('stroke-linecap', 'round');
    path.setAttribute('stroke-linejoin', 'round');
    path.setAttribute('stroke-width', '2');
    path.setAttribute('d', 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z');

    let icon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    icon.setAttribute('fill', 'none');
    icon.setAttribute('viewBox', '0 0 24 24');
    icon.setAttribute('stroke', 'currentColor');
    icon.style.height = '1.5em';
    icon.style.width = '1.5em';

    icon.appendChild(path);
    button.appendChild(icon)
    document.body.appendChild(button);
}

function openPopup() {
    if (typeof Swal == "undefined") {
        console.log('sweetalert is missing.');
    }

    Swal.fire({
        position: 'bottom-end',
        title: 'Let us know what\'s up!',
        input: 'textarea',
        showLoaderOnConfirm: true,
        backdrop: true,
        preConfirm: (message) => {
            post(`//PHP_REPLACE_HOST/api`, {
                'company': 'company_name',
                'username': 'username',
                'email': 'email',
                'message': message
            })
        },
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: 'bottom-end',
                icon: 'success',
                title: 'Thank You!',
                showConfirmButton: false,
                timer: 1500
            })
        }
    })
}

function post(url, params) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    const data = JSON.stringify(params);
    xhr.send(data);
}
