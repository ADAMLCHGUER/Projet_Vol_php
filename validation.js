function Validermail(){
    let mail = document.getElementById("mail").value;
    let res = mail.includes("@");
    if(!res){
        alert("Adresse e-mail invalide");
        return false;
    }
    let psw= document.getElementById("psw").value;
    let resu = psw.length ;
    if(resu < 8){
        alert("mot de passe trop court (8 caractere minimum)");
        return false;
    }
    return true;
    }
    function diffDate(){
        let dj =new Date();
        let dn = document .getElementById("date_naissance").value;
        let d1 =new Date(dn.toString());
        let dnn=new Date(d1.toUTCString());
    
        let diff_year=dj.getFullYear()-dnn.getFullYear();
        if (diff_year < 18){
            alert("Votre age est inferieur a 18 ");
            return false;
        }
        return true;
             //return diff_year;

    }
    function validateForm(){
        return Validermail() && diffDate();
    }