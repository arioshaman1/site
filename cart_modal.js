document.addEventListener("DOMContentLoaded", function() {
    var openModalBtn = document.getElementById("openModalBtn");
    var modal = document.getElementById("myModal");
    var totalPriceContent = document.getElementById("totalPrice");
    var confirmOrderBtn = document.getElementById("confirmOrderBtn");

    openModalBtn.addEventListener("click", function() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    totalPriceContent.textContent = response.total_price;
                    // Установка общей стоимости в скрытое поле формы
                    document.getElementById("totalPriceInput").value = response.total_price;
                    modal.style.display = "block"; // Показываем модальное окно
                } else {
                    console.error("Failed to fetch total price");
                }
            }
        };
        xhr.open("GET", "calculate_total_price.php", true);
        xhr.send();
    });

    // Обработка нажатия на кнопку "Оформить заказ"
    var checkoutBtn = document.getElementById("checkoutBtn");
    checkoutBtn.addEventListener("click", function() {
        // Отправка формы на страницу orders.php
        document.getElementById("orderForm").submit();
    });

    // Добавьте остальные обработчики событий, если они есть
});



    // Закрытие модального окна при клике на крестик
    var closeButton = document.getElementsByClassName("close")[0];
    closeButton.addEventListener("click", function() {
        modal.style.display = "none";
    });

    // Закрытие модального окна при клике вне его области
    window.addEventListener("click", function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });

    // Предотвращение закрытия модального окна при клике на элементы внутри модального окна
    modal.addEventListener("click", function(event) {
        event.stopPropagation();
    });


