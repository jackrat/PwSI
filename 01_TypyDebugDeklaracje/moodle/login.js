let eld = document.querySelector(".potentialidp");
if (eld !== null) {
    let ela = eld.children[0];
    if (ela !== null)
        ela.click();
}


let elb = document.querySelector(".form-button")
if (elb !== null) {
    {
        var was = localStorage.getItem("myClickedWas");      
        if (was !== "123") {
            console.log("1  "+localStorage.getItem("myClickedWas"));
            localStorage.setItem("myClickedWas", "123");            
            console.log("2  clicam");
            console.log("3    "+localStorage.getItem("myClickedWas"));
            setInterval(function(){ elb.click();} , 3000);
        }
        else 
        {
            console.log("4   nie clicam");
            console.log("5   "+localStorage.getItem("myClickedWas"));
            localStorage.setItem("myClickedWas", "666");
            console.log("6   "+localStorage.getItem("myClickedWas"));
            setInterval(function(){ elb.click();} , 3000);
        }
    }
}