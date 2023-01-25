const btnAdd = document.getElementsByClassName('btn btn-order');
const message = document.getElementById('alert');
const nbrItem = document.getElementById('nbrItem');

for (let i = 0; i < btnAdd.length; i++) {

    const link = btnAdd[i];

    link.addEventListener('click', function (e) {

        e.preventDefault();
        let idItem = this.dataset.id;
        let xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                message.textContent = xhr.responseText;
                let result = JSON.parse(xhr.responseText);
                message.classList.add("alert", "alert-success");
                message.style.visibility = "visible";
                message.textContent = "You have added one " + result.item.name;
                nbrItem.textContent = result.nbr_item;
            }

            // Message disappears after 2 sec
            const hideMessage = setTimeout(() => {
                message.style.visibility = "hidden";
            }, 2000);
        }

        xhr.open('POST', 'functions/cart.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.send('item=' + idItem);
    })
}