const API = window.location.origin + "/freelance_projectsss/test_project_1/backend/api";
let loggedIn = false;

fetch(`${API}/auth/check.php`)
    .then(r => r.json())
    .then(d => loggedIn = d.logged_in);

function loadProducts(cat) {
    fetch(`${API}/products/list.php?category_id=${cat}`)
        .then(r => r.json())
        .then(d => {
            products.innerHTML = "";
            d.data.forEach(p => {
                products.innerHTML += `
     <div class="card">
      <h3>${p.name}</h3>
      <p>${p.description}</p>
      ${loggedIn ? `<b>Price: ${p.price}</b>` : ``}
     </div>`;
            });
        });
}
