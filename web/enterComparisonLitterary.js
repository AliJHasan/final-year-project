function add() {
    var name1 = document.getElementById("name1").value;
    var city1 = document.getElementById("city1").value;
    var avg1 = document.getElementById("avg1").value;
    var numofstudent = document.getElementById("numofstudent").value;
    fetch ("http://127.0.0.1:8000/api/comparisonL",{
        method: "POST",
        body: JSON.stringify({
          name: name1,
          city: city1,
          avg: avg1,
          maxStudentsNumber: numofstudent
        }),
        headers: {
            "Content-type": "application/json; charset=UTF-8"
        }
    })
    .then(res=> res.json())
    .then(data => window.alert("done successfully"))
    .catch(err => console.log(err))
  }