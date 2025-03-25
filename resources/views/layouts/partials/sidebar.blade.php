<nav id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <h3>Menú</h3>
    </div>
    <ul class="sidebar-menu">
        <li>
            <a href="{{ route('dashboard') }}" class="active">
                <i class="icon">📊</i>
                <span>Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('products.index') }}">
                <i class="icon">📦</i>
                <span>Productos</span>
            </a>
        </li>
        <li>
            <a href="{{ route('categories.index') }}">
                <i class="icon">🏷️</i>
                <span>Categorías</span>
            </a>
        </li>

    </ul>
</nav>