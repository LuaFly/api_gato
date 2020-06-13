var button = document.getElementById("botaogato").addEventListener("submit", submit);

function submit(nome)
{

    function showcat(cat){
        var div =  document.createElement('div');
        var img = document.createElement('img');
        img.src = cat.url;
        div.appendChild(img);

        document.getElementsByClassName('box')[0].classList.add('invi');
        document.getElementsByClassName('card')[0].classList.remove('invi');


        document.getElementById("divcat").appendChild(div)
        cat.breeds[0].id;
        cat.breeds[0].name;
        cat.breeds[0].origin;
        console.log(cat.breeds[0].id)
        var p = document.createElement('p');
        p.innerHTML += "<br> nome: " + cat.breeds[0].name;
        p.innerHTML += " <br>origem: " + cat.breeds[0].origin;
        p.innerHTML += " <br>nivel de afeição: " + cat.breeds[0].affection_level;
        p.innerHTML += "<br> nivel de adaptação: " + cat.breeds[0].adaptability;
        p.innerHTML += "<br> Temperamento: " + cat.breeds[0].temperament;
        p.innerHTML += "<br> Descrição: " + cat.breeds[0].description;
        document.getElementById("infocat").appendChild(p);
        console.log(cat)
    
    }

    nome.preventDefault();

    var search = document.getElementById("search").value;


    document.getElementById('divcat').innerHTML = "";

    fetch("php/ligacao.php") .then(data => data.json()).then(data => {
        fetch("php/main.php?nome=" + search.replace(' ','_') + "&token="+data.token)
        .then(data => data.json()).then(data => {
        if((data.cod!=403) && (data.length >0)){
        for(i=0; i in data;i++) {
            showcat(data[i][0]);
        }
        } else {
            console.log(data);
            return  document.getElementById('erro').innerHTML = "Erro " + (data.msg ||  " Gato não encontrado");

        }})
        
    })  

}
