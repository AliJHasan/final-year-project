fetch("http://127.0.0.1:8000/api/resultsS")
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

// const fileInput = document.getElementById('csvFile');
// fileInput.onchange = () => {
//     const selected = fileInput.files[0];
//     console.log(selected)
// }




function run(){
    alert("done successfully");
    fetch ("http://127.0.0.1:8000/api/upload-resS",{
    method: "POST",
    body: JSON.stringify({
        uploaded_file : document.getElementById('csvFile').files[0]
    }),
    headers: {
        "Content-type": "application/json; charset=UTF-8"
    }
})
.then(res=> res.json())
.then(res=>console.log(res))
.catch(err => console.log(err))
}