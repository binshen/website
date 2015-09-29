//从数组中移除指定元素
    Array.prototype.indexOf = function(val) {
      for (var i = 0; i < this.length; i++) {
          if (this[i] == val) return i;
      }
      return -1;
    };
    Array.prototype.remove = function(val) {
      var index = this.indexOf(val);
      if (index > -1) {
          this.splice(index, 1);
      }
    };
  
  //位置 楼盘名 面积 写入cookies
  //function dataConfig(){
    var hLoca =document.getElementById("house-loca").innerHTML,hStyle = document.getElementById("house-style").innerHTML,hPrice = document.getElementById("house-price").innerHTML;
    
    var name = "houseInfo";
    var houseInfo;
  //}
  document.getElementById("jCompareBtn").onclick =function(){
    if(houseInfo.length>0){
      for(var i=0;i<houseInfo.length;i++){
        if(houseInfo[i].hId ==hId){
          alert("该房源已加入对比列中！");
          return;
        }
        else if(houseInfo.length>=2){
          alert("最多可对比两个房源!");
          return;
        }
      }
     }
      houseInfo.push({hId:hId,hLoca:hLoca,hStyle:hStyle,hPrice:hPrice});
      store.set(name,houseInfo);
      getLocalSto();
      
  }
  //get  local storage
  function getLocalSto(){
    //dataConfig();
    houseInfo = store.get(name);
    document.getElementById("Jcom-item").innerHTML = "";
    if(houseInfo instanceof Array){
      document.getElementById("Ji-num").innerHTML = "+"+houseInfo.length;
     for(var i =0; i<houseInfo.length;i++){
        var newLi = document.createElement("li");
        newLi.id = "li"+houseInfo[i].hId;
        newLi.innerHTML = "<p>"+houseInfo[i].hLoca+"<br/>"+houseInfo[i].hStyle+"<br/>"+"<i class='price'>"+houseInfo[i].hPrice+"</i></p><i class='am-icon-close' onclick='closeHouseInfo(this.parentNode.id)' ></i>";
         document.getElementById("Jcom-item").appendChild(newLi);
      }
    }
    else {
      houseInfo =[];
    }
  }
  getLocalSto();
  //store.remove(name);
  // var closeBtns = document.getElementsByClassName("am-icon-close");
  // for(var i=0; i<closeBtns.length;i++){
  //   closeBtns[i].onclick = function(){
  //     document.getElementById(this.parentNode.id).style.display ='none';
  //     deleteLoalSto(this.parentNode.id);
  //   }

  // }
  function closeHouseInfo(id){
    document.getElementById(id).style.display ='none';
      deleteLoalSto(id );

  }
  //delete local storage
  function deleteLoalSto(liid){
    var closeHouseId = liid.substring(2,liid.length);
    for(var i =0; i<houseInfo.length;i++){
      if(houseInfo[i].hId ==closeHouseId){
        houseInfo.remove(houseInfo[i]);  
      }
    }
    document.getElementById("Ji-num").innerHTML = "+"+houseInfo.length;
    store.set(name,houseInfo);
    //alert(houseInfo.length);
  }