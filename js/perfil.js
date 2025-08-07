
        var inf = document.getElementById('infa');
        var colorch = document.getElementById('karase');
        var ind = document.getElementById('dat');
        var iicon = document.getElementById('usericon').addEventListener('click', on);
        document.getElementById('Back_24').addEventListener('click', out);
        tran = document.getElementById('pfp');
      
        function on(){
            inf.style.right = "190px";
            tran.style.animation = "arph 0.9s";
            tran.style.animation = "movep 1s";
            }
         function out(){
            inf.style.right = "-500px";
            tran.style.animation = "outp 1s";
            tran.style.animation = "downp 1s";
        }
       
        photo = document.getElementById('selein');
        document.getElementById('pfp').addEventListener('click', geto);

        function geto(){
            photo.click();
        }
    
        
    
     
