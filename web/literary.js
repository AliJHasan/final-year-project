fetch("http://127.0.0.1:8000/api/comparisonL")
.then(res => res.json())
.then( data => show(data) )

function show(students){
    let table = document.getElementById('t1');
    for(let i = 0; i<students.length;i++){
        let obj = students[i];
        let row = document.createElement('tr');
        let number = document.createElement('td');
        let collage = document.createElement('td');
        let city = document.createElement('td');
        let avg = document.createElement('td');

        number.innerHTML = obj.id;
        
        collage.innerHTML = obj.name;
        city.innerHTML = obj.city;
        avg.innerHTML = obj.avg;


        row.appendChild(number)
        row.appendChild(collage)
        row.appendChild(city)
        row.appendChild(avg)


        table.appendChild(row)


    }
}


function run(){
    alert("done successfully");
}