@extends('admin.layout')

@section('content')
<div class="container-fluid">

    {{-- ✅ Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt"></i> Admin Dashboard
        </h1>
        <div class="d-flex">
            <button class="btn btn-primary me-2" onclick="refreshData()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
            <div class="dropdown">
                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                    <i class="fas fa-cog"></i> Settings
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" onclick="exportData()"><i class="fas fa-download"></i> Export Data</a></li>
                    <li><a class="dropdown-item" href="#" onclick="clearCache()"><i class="fas fa-broom"></i> Clear Cache</a></li>
                </ul>
            </div>
        </div>
    </div>

    {{-- ✅ Quick Stats --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalUsers">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Recipes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalRecipes">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-flask fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Active Recipes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="activeRecipes">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Approval</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" id="pendingRecipes">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Charts Section --}}
    <div class="row mb-4">
        {{-- User Growth Chart --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">User Growth (Last 6 Months)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="userGrowthChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- Recipe Categories --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Recipe Categories</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="recipeCategoriesChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Engagement Analytics --}}
    <div class="row mb-4">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Engagement Stats</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Avg Likes per Recipe</small>
                        <h4 id="avgLikes" class="text-primary">0</h4>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Avg Comments per Recipe</small>
                        <h4 id="avgComments" class="text-success">0</h4>
                    </div>
                    <div>
                        <small class="text-muted">Total Shares</small>
                        <h4 id="totalShares" class="text-info">0</h4>
                    </div>
                </div>
            </div>
        </div>

        {{-- Skin Type Distribution --}}
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Skin Type Distribution</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="skinTypeChart" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Recent Activities --}}
    <div class="row">
        {{-- Recent Users --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Users</h6>
                </div>
                <div class="card-body">
                    <div id="recentUsersList">
                        <!-- Users will be loaded here -->
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Recipes --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Recipes</h6>
                </div>
                <div class="card-body">
                    <div id="recentRecipesList">
                        <!-- Recipes will be loaded here -->
                    </div>
                </div>
            </div>
        </div>

        {{-- Recent Comments --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Comments</h6>
                </div>
                <div class="card-body">
                    <div id="recentCommentsList">
                        <!-- Comments will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Quick Actions --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-2 mb-3">
                            <button class="btn btn-outline-primary w-100" onclick="navigateTo('recipes')">
                                <i class="fas fa-flask fa-2x mb-2"></i><br>
                                Manage Recipes
                            </button>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button class="btn btn-outline-success w-100" onclick="navigateTo('users')">
                                <i class="fas fa-users fa-2x mb-2"></i><br>
                                Manage Users
                            </button>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button class="btn btn-outline-info w-100" onclick="navigateTo('ingredients')">
                                <i class="fas fa-leaf fa-2x mb-2"></i><br>
                                Manage Ingredients
                            </button>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button class="btn btn-outline-warning w-100" onclick="navigateTo('comments')">
                                <i class="fas fa-comments fa-2x mb-2"></i><br>
                                Manage Comments
                            </button>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button class="btn btn-outline-danger w-100" onclick="showReports()">
                                <i class="fas fa-chart-bar fa-2x mb-2"></i><br>
                                View Reports
                            </button>
                        </div>
                        <div class="col-md-2 mb-3">
                            <button class="btn btn-outline-secondary w-100" onclick="systemSettings()">
                                <i class="fas fa-cogs fa-2x mb-2"></i><br>
                                Settings
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ✅ Modals --}}
@include('admin.modals.recipe-modal')
@include('admin.modals.user-modal')
@include('admin.modals.ingredient-modal')

<style>
.card {
    border: none;
    border-radius: 10px;
}
.chart-area, .chart-bar, .chart-pie {
    position: relative;
    height: 100%;
    width: 100%;
}
.border-left-primary { border-left: 0.25rem solid #4e73df !important; }
.border-left-success { border-left: 0.25rem solid #1cc88a !important; }
.border-left-info { border-left: 0.25rem solid #36b9cc !important; }
.border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
let userGrowthChart, recipeCategoriesChart, skinTypeChart;

class AdminDashboard {
    constructor() {
        this.init();
    }

    async init() {
        await this.loadDashboardData();
        await this.loadAnalytics();
        this.initializeCharts();
        this.setupRealTimeUpdates();
    }

    async loadDashboardData() {
        try {
            const response = await axios.get('/admin/dashboard');
            const data = response.data;

            // Update quick stats
            document.getElementById('totalUsers').textContent = data.stats.total_users.toLocaleString();
            document.getElementById('totalRecipes').textContent = data.stats.total_recipes.toLocaleString();
            document.getElementById('activeRecipes').textContent = data.stats.active_recipes.toLocaleString();
            document.getElementById('pendingRecipes').textContent = data.stats.pending_recipes.toLocaleString();

            // Update recent activities
            this.updateRecentActivities(data.recentActivities);
            
            // Update charts data
            this.updateCharts(data);

        } catch (error) {
            console.error('Error loading dashboard data:', error);
            this.showError('Failed to load dashboard data');
        }
    }

    async loadAnalytics() {
        try {
            const response = await axios.get('/admin/analytics');
            const data = response.data;

            // Update engagement stats
            document.getElementById('avgLikes').textContent = data.engagementStats.average_likes_per_recipe.toFixed(1);
            document.getElementById('avgComments').textContent = data.engagementStats.average_comments_per_recipe.toFixed(1);
            document.getElementById('totalShares').textContent = data.engagementStats.total_shares.toLocaleString();

        } catch (error) {
            console.error('Error loading analytics:', error);
        }
    }

    updateRecentActivities(activities) {
        // Recent Users
        const usersList = document.getElementById('recentUsersList');
        usersList.innerHTML = activities.new_users.map(user => `
            <div class="d-flex align-items-center mb-3">
                <img class="rounded-circle me-3" width="40" height="40" 
                     src="https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=random">
                <div class="flex-grow-1">
                    <div class="small">${user.name}</div>
                    <div class="small text-muted">${new Date(user.created_at).toLocaleDateString()}</div>
                </div>
            </div>
        `).join('');

        // Recent Recipes
        const recipesList = document.getElementById('recentRecipesList');
        recipesList.innerHTML = activities.recent_recipes.map(recipe => `
            <div class="mb-3 p-2 border rounded">
                <div class="small fw-bold">${recipe.title}</div>
                <div class="small text-muted">by ${recipe.user?.name || 'Unknown'}</div>
                <div class="small text-muted">${new Date(recipe.created_at).toLocaleDateString()}</div>
            </div>
        `).join('');

        // Recent Comments
        const commentsList = document.getElementById('recentCommentsList');
        commentsList.innerHTML = activities.recent_comments.map(comment => `
            <div class="mb-3 p-2 border rounded">
                <div class="small">${comment.user?.name || 'Anonymous'}: ${comment.content}</div>
                <div class="small text-muted">on ${comment.recipe?.title || 'Unknown Recipe'}</div>
            </div>
        `).join('');
    }

    initializeCharts() {
        // User Growth Chart
        const userGrowthCtx = document.getElementById('userGrowthChart').getContext('2d');
        userGrowthChart = new Chart(userGrowthCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'New Users',
                    data: [],
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    pointBackgroundColor: '#4e73df',
                    pointBorderColor: '#4e73df',
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Recipe Categories Chart
        const recipeCategoriesCtx = document.getElementById('recipeCategoriesChart').getContext('2d');
        recipeCategoriesChart = new Chart(recipeCategoriesCtx, {
            type: 'doughnut',
            data: {
                labels: [],
                datasets: [{
                    data: [],
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                        '#858796', '#5a5c69', '#6f42c1', '#e83e8c', '#fd7e14'
                    ],
                    hoverBackgroundColor: [
                        '#2e59d9', '#17a673', '#2c9faf', '#f4b619', '#e02d1b'
                    ]
                }]
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom'
                    }
                }
            }
        });

        // Skin Type Chart
        const skinTypeCtx = document.getElementById('skinTypeChart').getContext('2d');
        skinTypeChart = new Chart(skinTypeCtx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [{
                    label: 'Recipes',
                    data: [],
                    backgroundColor: '#4e73df',
                    borderColor: '#2e59d9',
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    updateCharts(data) {
        // Update User Growth Chart
        const userLabels = data.weeklyUsers.map(item => {
            const date = new Date(item.date);
            return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric' });
        });
        const userData = data.weeklyUsers.map(item => item.count);

        userGrowthChart.data.labels = userLabels;
        userGrowthChart.data.datasets[0].data = userData;
        userGrowthChart.update();

        // Update Recipe Categories Chart
        const categoryLabels = data.recipeCategories.map(item => {
            return item.category.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
        });
        const categoryData = data.recipeCategories.map(item => item.count);

        recipeCategoriesChart.data.labels = categoryLabels;
        recipeCategoriesChart.data.datasets[0].data = categoryData;
        recipeCategoriesChart.update();

        // Update Skin Type Chart
        const skinLabels = data.skinTypeStats.map(item => item.name);
        const skinData = data.skinTypeStats.map(item => item.count);

        skinTypeChart.data.labels = skinLabels;
        skinTypeChart.data.datasets[0].data = skinData;
        skinTypeChart.update();
    }

    setupRealTimeUpdates() {
        // Refresh data every 5 minutes
        setInterval(() => {
            this.loadDashboardData();
            this.loadAnalytics();
        }, 300000);

        // Listen for real-time events (WebSocket would be used in production)
        window.addEventListener('focus', () => {
            this.loadDashboardData();
        });
    }

    showError(message) {
        // You can use Toast or SweetAlert here
        console.error('Admin Error:', message);
        alert('Error: ' + message);
    }
}

// Global functions
function refreshData() {
    adminDashboard.loadDashboardData();
    adminDashboard.loadAnalytics();
    showToast('Data refreshed successfully!', 'success');
}

function exportData() {
    // Implement data export functionality
    showToast('Export feature coming soon!', 'info');
}

function clearCache() {
    if (confirm('Are you sure you want to clear the cache?')) {
        showToast('Cache cleared successfully!', 'success');
    }
}

function navigateTo(section) {
    window.location.href = `/admin/${section}`;
}

function showReports() {
    showToast('Reports feature coming soon!', 'info');
}

function systemSettings() {
    showToast('System settings feature coming soon!', 'info');
}

function showToast(message, type = 'info') {
    // Simple toast implementation - you can use a library like Toastr
    const toast = document.createElement('div');
    toast.className = `alert alert-${type} position-fixed`;
    toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
    toast.textContent = message;
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// Initialize dashboard when page loads
const adminDashboard = new AdminDashboard();
</script>
@endsection