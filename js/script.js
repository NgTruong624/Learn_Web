const menuli = document.querySelectorAll('.admin-sidebar-content > ul > li >a')

for (let index = 0; index < menuli.length; index++) {
    menuli[index].addEventListener('click', (e)=> {
        e.preventDefault()
        menuli[index].parentNode.querySelector('ul').classList.toggle('active')
//console.log(menuli[index].parentNode.querySelector('ul').classList.toggle('active'))
})
}



document.getElementById('moreoption').addEventListener('change', function(){
    var url = this.value;
    if(url){
        window.location.href=url;
    }
});

// Hàm tải dữ liệu JSON

async function load_Data() {
    try {
        const response = await fetch('json/products.json');
        return await response.json();
    } catch(error){
        console.error('không thể tải dữ liệu', error);
    }
}

// Hàm tìm kiếm sản phẩm 
async function search_Product(){
    const keyword = document.getElementById("search-input").value.toLowerCase();
    const data = await load_Data();
    const resultDiv = document.getElementById('products');
    resultDiv.innerHTML ='';
    const result = Object.values(data).filter(product =>{
        return product.name.toLowerCase().includes(keyword);
    });
    if(result.length > 0){
        result.forEach(product => {
            const productDiv = document.createElement('div');
            productDiv.className = 'product';
            productDiv.innerHTML = `
                <h2>${product.name}</h2>
                <a href="productdetail.html?productId=${product.id}" class="product-thumb">
                    <img src="${product.image}" alt="${product.name}">
                </a>
                <p>Giá: ${product.price}</p>
            `;
            resultDiv.appendChild(productDiv);
        });
    }else{
        resultDiv.innerHTML= "<p>Không tìm thấy sản phẩm </p>";
    }
}