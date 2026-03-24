// Sample Data
let students = [
    { name: "Arun", dept: "CSE", date: "2024-02-10" },
    { name: "Bala", dept: "ECE", date: "2023-12-01" },
    { name: "Charan", dept: "IT", date: "2024-01-15" },
    { name: "Divya", dept: "CSE", date: "2023-11-20" },
    { name: "Esha", dept: "ECE", date: "2024-03-05" }
];

// Display Data
function displayData(data) {
    let tableBody = document.getElementById("tableBody");
    tableBody.innerHTML = "";

    data.forEach(student => {
        let row = `
            <tr>
                <td>${student.name}</td>
                <td>${student.dept}</td>
                <td>${student.date}</td>
            </tr>
        `;
        tableBody.innerHTML += row;
    });
}

// Sort by Name
function sortByName() {
    students.sort((a, b) => a.name.localeCompare(b.name));
    displayData(students);
    updateCount(students);
}

// Sort by Date
function sortByDate() {
    students.sort((a, b) => new Date(a.date) - new Date(b.date));
    displayData(students);
    updateCount(students);
}

// Filter by Department
document.getElementById("departmentFilter").addEventListener("change", function () {
    let selectedDept = this.value;

    if (selectedDept === "All") {
        displayData(students);
        updateCount(students);
    } else {
        let filtered = students.filter(student => student.dept === selectedDept);
        displayData(filtered);
        updateCount(filtered);
    }
});

// Count per Department
function updateCount(data) {
    let count = {};

    data.forEach(student => {
        count[student.dept] = (count[student.dept] || 0) + 1;
    });

    let result = "Count: ";
    for (let dept in count) {
        result += `${dept} = ${count[dept]}  `;
    }

    document.getElementById("countDisplay").innerText = result;
}

// Initial Load
displayData(students);
updateCount(students);