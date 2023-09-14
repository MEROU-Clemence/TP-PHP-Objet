// Fonction pour mettre à jour la sélection de la deuxième date en fonction de la première
function updateSecondDateSelection() {
    // Obtenez les valeurs sélectionnées pour la première date
    const firstDay = parseInt(document.querySelector("select[name='first_day']").value);
    const firstMonth = parseInt(document.querySelector("select[name='first_month']").value);
    const firstYear = parseInt(document.querySelector("select[name='first_year']").value);

    // Obtenez les sélecteurs pour la deuxième date
    const secondDaySelect = document.querySelector("select[name='second_day']");
    const secondMonthSelect = document.querySelector("select[name='second_month']");
    const secondYearSelect = document.querySelector("select[name='second_year']");

    // Effacez toutes les options précédentes pour la deuxième date
    secondDaySelect.innerHTML = "";
    secondMonthSelect.innerHTML = "";
    secondYearSelect.innerHTML = "";

    // Générez les options pour la deuxième date en fonction de la première
    for (let day = firstDay; day <= 31; day++) {
        const option = document.createElement("option");
        option.value = day;
        option.textContent = day;
        secondDaySelect.appendChild(option);
    }

    for (let month = firstMonth; month <= 12; month++) {
        const option = document.createElement("option");
        option.value = month;
        option.textContent = month;
        secondMonthSelect.appendChild(option);
    }

    for (let year = firstYear; year <= firstYear + 10; year++) {
        const option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        secondYearSelect.appendChild(option);
    }
}

// Ajoutez un écouteur d'événements "change" à la première date pour mettre à jour la deuxième date
document.querySelector("select[name='first_day']").addEventListener("change", updateSecondDateSelection);
document.querySelector("select[name='first_month']").addEventListener("change", updateSecondDateSelection);
document.querySelector("select[name='first_year']").addEventListener("change", updateSecondDateSelection);

// Appelez la fonction initiale pour configurer les options de la deuxième date
updateSecondDateSelection();