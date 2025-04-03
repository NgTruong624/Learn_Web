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
    const resultDiv = document.getElementById('abc');
    resultDiv.innerHTML = "";
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
                <p>Giá: <span style="color: red;">${product.price}</span> </p>
            `;
            resultDiv.appendChild(productDiv);
        });
    }else{
        resultDiv.innerHTML= "<p>Không tìm thấy sản phẩm </p>";
    }
}
