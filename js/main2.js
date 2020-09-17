function search(name){
    console.log(name);
   fetchSearchData(name);
}

function fetchSearchData(name){
    
   
   fetch('processors/search.php',{
     method:'POST',
     //body: JSON.stringify("name": name),
     body: new URLSearchParams(`name=${name}`),
    //  headers: {
    //     "Content-Type": "application/json"
    //   }
   })
   .then(res => res.json())
   .then(res => console.log(res))
   .then(res => console.error('Error: ' + e))
 }

  //  function viewSearchResult(data){
    //    const dataViewer = document.getElementById('dataViewer');

    //    dataViewer.innerHTML = " ";

    //    for(let i = 0; i < data.lenght; i++){

    //    }
    //  }