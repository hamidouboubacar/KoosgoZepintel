var client = document.getElementById('client_name').value
const nom_client = client.split(' ');
const code = document.getElementById('data-bon').getAttribute('data-bon')
console.log(code)
var prefix="";
if(code<1000&&code<100&&code<10){prefix="000";}
if(code<1000&&code<100&&code>10){prefix="00";}
if(code<1000&&code>100&&code>10){prefix="0";}
var date = new Date();
var jour = date.getDate();
var mois = ("0" + (date.getMonth() + 1)).slice(-2);
var annee = date.getFullYear();
var year = annee.toString().substr(-2);
document.getElementById('numero_bl').value='BL'+prefix+code+'/'+year+'/'+mois+'/'+jour+'/'+nom_client[0]+'/'+code

// +annee+'/'+mois+'/'+jour+'/'+code;
