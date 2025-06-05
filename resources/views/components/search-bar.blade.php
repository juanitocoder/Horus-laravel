
<div class="modern-search-wrapper">
    <form action="{{ route('products.search') }}" method="GET" class="search-form">
        <div class="search-input-wrapper">
            <svg class="search-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input 
                type="text" 
                name="search" 
                id="modernSearchInput"
                class="modern-search-input" 
                placeholder="Buscar productos..."
                value="{{ request('search') }}"
                autocomplete="off"
            >
            <button type="submit" class="search-submit-btn" aria-label="Buscar">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.35-4.35"></path>
                </svg>
            </button>
        </div>
    </form>
    
    <!-- Dropdown de resultados - Completamente flotante -->
    <div id="modernSearchResults" class="search-dropdown">
        <div class="search-dropdown-content">
            <!-- Resultados se cargan aquí -->
        </div>
    </div>
</div>

<style>
/* Reset y base styles */
.modern-search-wrapper {
    position: relative;
    width: 100%;
    max-width: 400px;
    margin: 0;
    z-index: 1000;
}

.search-form {
    position: relative;
    width: 100%;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 25px;
    padding: 2px;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    transition: all 0.3s ease;
}

.search-input-wrapper:focus-within {
    box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
    transform: translateY(-2px);
}

.search-icon {
    position: absolute;
    left: 15px;
    color: #8b95a1;
    z-index: 2;
    transition: color 0.3s ease;
}

.modern-search-input {
    width: 100%;
    height: 50px;
    border: none;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 23px;
    padding: 0 50px 0 50px;
    font-size: 16px;
    font-weight: 400;
    color: #2d3748;
    outline: none;
    transition: all 0.3s ease;
}

.modern-search-input::placeholder {
    color: #a0aec0;
    font-weight: 400;
}

.modern-search-input:focus {
    background: rgba(255, 255, 255, 1);
    box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.1);
}

.modern-search-input:focus + .search-icon {
    color: #667eea;
}

.search-submit-btn {
    position: absolute;
    right: 5px;
    width: 40px;
    height: 40px;
    border: none;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    color: white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(102, 126, 234, 0.4);
}

.search-submit-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.6);
}

.search-submit-btn:active {
    transform: scale(0.95);
}

/* Dropdown de resultados - COMPLETAMENTE FLOTANTE */
.search-dropdown {
    position: fixed !important;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    pointer-events: none;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.search-dropdown.show {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

.search-dropdown-content {
    position: absolute;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    max-height: 400px;
    overflow-y: auto;
    min-width: 350px;
    max-width: 500px;
    margin-top: 8px;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Scrollbar personalizado */
.search-dropdown-content::-webkit-scrollbar {
    width: 6px;
}

.search-dropdown-content::-webkit-scrollbar-track {
    background: transparent;
}

.search-dropdown-content::-webkit-scrollbar-thumb {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 3px;
}

/* Elementos de resultado */
.search-result-item {
    padding: 16px 20px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.search-result-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.1), transparent);
    transition: left 0.5s ease;
}

.search-result-item:hover::before {
    left: 100%;
}

.search-result-item:hover {
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    transform: translateX(5px);
}

.search-result-item:last-child {
    border-bottom: none;
    border-radius: 0 0 20px 20px;
}

.search-result-item:first-child {
    border-radius: 20px 20px 0 0;
}

.product-info {
    display: flex;
    align-items: center;
    width: 100%;
    position: relative;
    z-index: 1;
}

.product-image {
    width: 55px;
    height: 55px;
    object-fit: cover;
    border-radius: 12px;
    margin-right: 16px;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.search-result-item:hover .product-image {
    transform: scale(1.05);
}

.product-image-placeholder {
    width: 55px;
    height: 55px;
    background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
    border-radius: 12px;
    margin-right: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.product-image-placeholder i {
    color: #a0aec0;
    font-size: 20px;
}

.product-details {
    flex: 1;
    min-width: 0;
}

.product-name {
    margin: 0 0 6px 0;
    font-size: 16px;
    font-weight: 600;
    color: #2d3748;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: color 0.3s ease;
}

.search-result-item:hover .product-name {
    color: #667eea;
}

.product-description {
    font-size: 13px;
    color: #718096;
    margin: 0 0 8px 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-price {
    font-weight: 700;
    font-size: 16px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
}

.search-no-results {
    padding: 40px 30px;
    text-align: center;
    color: #718096;
    font-size: 16px;
}

.search-no-results::before {
    content: '🔍';
    display: block;
    font-size: 40px;
    margin-bottom: 16px;
    opacity: 0.5;
}

/* Responsive */
@media (max-width: 768px) {
    .modern-search-wrapper {
        max-width: 280px;
    }
    
    .search-dropdown-content {
        min-width: 300px;
        margin-left: -50px;
    }
    
    .modern-search-input {
        font-size: 16px; /* Previene zoom en iOS */
    }
}

/* Animaciones adicionales */
@keyframes pulse {
    0% {
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    50% {
        box-shadow: 0 6px 25px rgba(102, 126, 234, 0.6);
    }
    100% {
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
}

.search-input-wrapper.searching {
    animation: pulse 1.5s infinite;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('modernSearchInput');
    const searchResults = document.getElementById('modernSearchResults');
    const searchWrapper = document.querySelector('.modern-search-wrapper');
    const inputWrapper = document.querySelector('.search-input-wrapper');
    let searchTimeout;

    // Función para posicionar el dropdown
    function positionDropdown() {
    const rect = searchInput.getBoundingClientRect();
    const dropdown = searchResults.querySelector('.search-dropdown-content');

    const scrollTop = window.scrollY || document.documentElement.scrollTop;
    const scrollLeft = window.scrollX || document.documentElement.scrollLeft;

    dropdown.style.top = (rect.bottom + scrollTop) + 'px';
    dropdown.style.left = (rect.left + scrollLeft) + 'px';
    dropdown.style.width = rect.width + 'px';
}

    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            hideResults();
            return;
        }

        // Mostrar indicador de carga
        inputWrapper.classList.add('searching');

        searchTimeout = setTimeout(() => {
            fetch(`{{ route('products.search.ajax') }}?search=${encodeURIComponent(query)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                displayResults(data.products);
                inputWrapper.classList.remove('searching');
            })
            .catch(error => {
                console.error('Error:', error);
                inputWrapper.classList.remove('searching');
            });
        }, 300);
    });

    function displayResults(products) {
        const dropdownContent = searchResults.querySelector('.search-dropdown-content');
        
        if (products.length === 0) {
            dropdownContent.innerHTML = '<div class="search-no-results">No se encontraron productos</div>';
        } else {
            dropdownContent.innerHTML = products.map(product => `
                <div class="search-result-item" onclick="navigateToProduct(${product.id})">
                    <div class="product-info">
                        ${product.image ? 
                            `<img src="/storage/${product.image}" alt="${product.name}" class="product-image">` : 
                            '<div class="product-image-placeholder"><i class="fas fa-image"></i></div>'
                        }
                        <div class="product-details">
                            <div class="product-name">${product.name}</div>
                            ${product.description ? `<div class="product-description">${product.description}</div>` : ''}
                            <div class="product-price">$${parseFloat(product.price).toLocaleString()}</div>
                        </div>
                    </div>
                </div>
            `).join('');
        }
        
        showResults();
    }

   function showResults() {
        positionDropdown();
        searchResults.classList.add('show');
    }

    function hideResults() {
        searchResults.classList.remove('show');
        // Limpiar selecciones de teclado al cerrar
        document.querySelectorAll('.search-result-item.keyboard-selected').forEach(item => {
            item.classList.remove('keyboard-selected');
        });
    }

    // Navegación a producto
    window.navigateToProduct = function(productId) {
        hideResults(); // Cerrar dropdown antes de navegar
        window.location.href = `/products/${productId}`;
    };

    // Ocultar al hacer click fuera o en cualquier resultado
    document.addEventListener('click', function(event) {
    if (!searchWrapper.contains(event.target)) {
        setTimeout(() => {
            hideResults();
        }, 100); // Espera a que otros eventos de foco terminen
    }
});

    // Cerrar dropdown al hacer click en cualquier resultado
    searchResults.addEventListener('click', function(event) {
        if (event.target.closest('.search-result-item')) {
            hideResults();
        }
    });

    // Reposicionar en scroll y resize
    window.addEventListener('scroll', positionDropdown);
    window.addEventListener('resize', positionDropdown);

    // Navegación con teclado
    searchInput.addEventListener('keydown', function(event) {
        const items = document.querySelectorAll('.search-result-item');
        const current = document.querySelector('.search-result-item.keyboard-selected');
        let index = current ? Array.from(items).indexOf(current) : -1;

        switch(event.key) {
            case 'ArrowDown':
                event.preventDefault();
                if (current) current.classList.remove('keyboard-selected');
                index = Math.min(index + 1, items.length - 1);
                if (items[index]) items[index].classList.add('keyboard-selected');
                break;
                
            case 'ArrowUp':
                event.preventDefault();
                if (current) current.classList.remove('keyboard-selected');
                index = Math.max(index - 1, 0);
                if (items[index]) items[index].classList.add('keyboard-selected');
                break;
                
            case 'Enter':
                if (current) {
                    event.preventDefault();
                    current.click();
                }
                break;
                
            case 'Escape':
                hideResults();
                break;
        }
    });
});
</script>
