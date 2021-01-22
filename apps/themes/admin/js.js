function popup(url,name,windowWidth,windowHeight){      
    myleft=(screen.width)?(screen.width-windowWidth)/2:100;   
    mytop=(screen.height)?(screen.height-windowHeight)/2:100;     
    properties = "width="+windowWidth+",height="+windowHeight;  
    properties +=",scrollbars=yes, top="+mytop+",left="+myleft;     
    window.open(url,name,properties);  
}