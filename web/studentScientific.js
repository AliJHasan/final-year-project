fetch("http://127.0.0.1:8000/api/studentS")
.then(res => res.json())
.then( data => show(data) )

function show(students){
    let table = document.getElementById('table');
    for(let i = 0; i<students.length;i++){
        let obj = students[i];
        console.log(obj.password);
        let row = document.createElement('tr');
        let id = document.createElement('td');
        let fullName = document.createElement('td');
        let motherName = document.createElement('td');
        let address = document.createElement('td');
        let subscriptionNumber = document.createElement('td');
        let nationalNumber = document.createElement('td');
        let schoolName = document.createElement('td');

        id.innerHTML = obj.id;
        fullName.innerHTML = obj.fullName;
        motherName.innerHTML = obj.motherName;
        address.innerHTML = obj.address;
        subscriptionNumber.innerHTML = obj.subscriptionNumber;
        nationalNumber.innerHTML = obj.phoneNumber;
        schoolName.innerHTML = obj.schoolName;

        row.appendChild(id)
        row.appendChild(fullName)
        row.appendChild(motherName)
        row.appendChild(address)
        row.appendChild(subscriptionNumber)
        row.appendChild(nationalNumber)
        row.appendChild(schoolName)

        table.appendChild(row)
    }
}