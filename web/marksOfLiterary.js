fetch("http://127.0.0.1:8000/api/resultsL")
.then(res => res.json())
.then( data => show(data) )

function show(students){
    let table = document.getElementById('t1');
    for(let i = 0; i<students.length;i++){
        let obj = students[i];
        console.log(obj.password);
        let row = document.createElement('tr');
        let fullName = document.createElement('td');
        let subscriptionNumber = document.createElement('td');
        let mark = document.createElement('td');

        fullName.innerHTML = obj.fullname;
        subscriptionNumber.innerHTML = obj.subscriptionNumber;
        mark.innerHTML = obj.totalSum;

       row.appendChild(fullName)
        row.appendChild(subscriptionNumber)
        row.appendChild(mark)

        table.appendChild(row)


    }
}


function run(){
    alert("done successfully");
}