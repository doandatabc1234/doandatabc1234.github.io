var data = [
{
	 ten : " Lúc nào tôi cũng bay theo hướng bay của người khác. Lần này tôi sẽ bay theo con đường mà tôi đã lựa chọn.",
	 tacGia : "ẩn danh",
	 img : "images/1.jpg"
},
{
	ten : " Cuộc sống không phải là phim ảnh, không có nhiều đến thế… những lần không hẹn mà gặp",
	tacGia : "ẩn danh",
	img : "images/2.jpg"
},
{
	ten :  "Đôi khi, không cẩn thận biết một số chuyện, mới phát hiện ra rằng những điều bản thân để tâm lại nực cười đến thế",
	tacGia : "ẩn danh",
	img : "images/3.jpg"
},
{
	ten :  " Ai không giả dối, ai không dễ thay đổi, không ai là ai của ai hết. Hà tất phải coi một số người, một số chuyện quan trọng đến thế.",
	tacGia : "ẩn danh",
	img : "images/4.jpg"
},
{
	ten :  "Tình yêu, tình bạn, không phải là cả đời không cãi nhau, mà là cãi nhau rồi vẫn có thể bên nhau cả đời.",
	tacGia : "ẩn danh",
	img : "images/5.jpg"
},
{
	ten :  "Sự chân thành là điều tốt đẹp nhất bạn có thể đem trao tặng một người. Sự thật, lòng tin cậy, tình bạn và tình yêu đều tùy thuộc vào điều đó cả.",
	tacGia : "ẩn danh",
	img : "images/6.jpg"
},
{
	ten :  " Đừng nói mà hãy làm. Đừng huyên thuyên mà hãy hành động. Đừng hứa mà hãy chứng minh.",
	tacGia : "ẩn danh",
	img : "images/7.jpg"
},
	{
	ten :  "Đối với bạn mà nói, sẽ chẳng bao giờ là quá già để có một mục tiêu mới hay để mơ một giấc mơ mới. ",
	tacGia : "ẩn danh",
	img : "images/8.jpg"
}
		];
		function makerandomnumber(range){
			return Math.floor(Math.random()*range); // 0  -> range
		}
		function getTitle(){
			return data[makerandomnumber(data.length)];
		}
		function getdata(){
			var get = getTitle();
			 var elmten = document.getElementById("title");
			 var elmTacGia = document.getElementById("author");			 
			 var elmimg = document.getElementById("bg");			 
			 elmten.innerText= get.ten;
			 elmTacGia.innerText = get.tacGia;
			 elmimg.src = get.img;  			  	

		}
		