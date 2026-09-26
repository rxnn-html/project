<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CANOY Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            /* Same bg2.jfif image, dark neutral-black overlay (no blue tint) */
            background: linear-gradient(rgba(10, 10, 10, 0.75), rgba(20, 20, 20, 0.8)), url("{{ asset('images/bg2.jfif') }}") no-repeat center center fixed;
            background-size: cover;
            color: #f1f5f9;
        }

        /* Gray-toned glass surfaces */
        .surface-topbar {
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.1);
        }

        .surface-card {
            background: rgba(23, 23, 23, 0.55);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(226, 232, 240, 0.12);
            box-shadow: 0 8px 28px 0 rgba(0, 0, 0, 0.4);
        }

        .surface-input {
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(226, 232, 240, 0.14);
            color: #f8fafc;
            transition: all 0.2s ease;
        }

        .surface-input:focus {
            outline: none;
            border-color: rgba(226, 232, 240, 0.4);
            box-shadow: 0 0 0 2px rgba(226, 232, 240, 0.12);
        }

        .surface-input option {
            background-color: #334155;
            color: #f8fafc;
        }

        .btn-flat {
            background: rgba(226, 232, 240, 0.1);
            border: 1px solid rgba(226, 232, 240, 0.18);
            transition: all 0.2s ease;
        }

        .btn-flat:hover {
            background: rgba(226, 232, 240, 0.2);
            border-color: rgba(226, 232, 240, 0.32);
        }

        .btn-primary {
            background: rgba(226, 232, 240, 0.22);
            border: 1px solid rgba(226, 232, 240, 0.4);
            color: #f8fafc;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: rgba(226, 232, 240, 0.34);
            border-color: rgba(226, 232, 240, 0.55);
        }

        .tab-active {
            background: rgba(226, 232, 240, 0.18);
            border: 1px solid rgba(226, 232, 240, 0.28);
            color: #f8fafc;
        }

        .tab-inactive {
            color: #cbd5e1;
        }

        .tab-inactive:hover {
            background: rgba(226, 232, 240, 0.08);
            color: #f8fafc;
        }

        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: rgba(0, 0, 0, 0.2); }
        ::-webkit-scrollbar-thumb { background: rgba(226, 232, 240, 0.25); border-radius: 9999px; }
    </style>
</head>
<body class="h-full flex flex-col overflow-x-hidden selection:bg-slate-300 selection:text-slate-900">

    <!-- TOP BAR: branding + nav tabs + actions (replaces the old left sidebar) -->
    <header class="surface-topbar w-full sticky top-0 z-20">
        <div class="max-w-7xl mx-auto px-4 md:px-8 py-4 flex flex-col lg:flex-row lg:items-center gap-4">

            <!-- Branding -->
            <div class="flex items-center gap-3 shrink-0">
                <div class="w-9 h-9 rounded-xl surface-card flex items-center justify-center text-slate-100 font-bold text-sm">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <h1 class="font-bold text-xs tracking-wider uppercase text-slate-50">CANOY Task</h1>
                    <p class="text-[10px] text-slate-300 font-medium">Manager Dashboard</p>
                </div>
            </div>

            <!-- Nav Tabs -->
            <nav class="flex items-center gap-1.5 surface-card rounded-xl p-1 w-full lg:w-auto">
                <button onclick="setFilter('all')" id="nav-all" class="flex-1 lg:flex-none flex items-center justify-center gap-2 px-3.5 py-2 rounded-lg text-xs font-medium tab-active transition-all">
                    <i class="fa-solid fa-folder-open text-[11px]"></i> All
                    <span id="badge-all" class="text-[10px] px-1.5 py-0.5 rounded-md bg-black/20">0</span>
                </button>
                <button onclick="setFilter('pending')" id="nav-pending" class="flex-1 lg:flex-none flex items-center justify-center gap-2 px-3.5 py-2 rounded-lg text-xs font-medium tab-inactive transition-all">
                    <i class="fa-solid fa-hourglass-half text-[11px] text-amber-300"></i> Pending
                    <span id="badge-pending" class="text-[10px] px-1.5 py-0.5 rounded-md bg-black/20">0</span>
                </button>
                <button onclick="setFilter('completed')" id="nav-completed" class="flex-1 lg:flex-none flex items-center justify-center gap-2 px-3.5 py-2 rounded-lg text-xs font-medium tab-inactive transition-all">
                    <i class="fa-solid fa-circle-check text-[11px] text-emerald-300"></i> Completed
                    <span id="badge-completed" class="text-[10px] px-1.5 py-0.5 rounded-md bg-black/20">0</span>
                </button>
            </nav>

            <!-- Search + New Task -->
            <div class="flex items-center gap-3 w-full lg:w-auto lg:ml-auto">
                <div class="relative flex-1 lg:w-64">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-300">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" id="searchInput" oninput="handleSearch()" placeholder="Search tasks..." class="w-full surface-input pl-10 pr-4 py-2 rounded-xl text-xs font-medium">
                </div>
                <button onclick="openModal()" class="btn-primary px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 shrink-0">
                    <i class="fa-solid fa-plus text-[10px]"></i> <span class="hidden sm:inline">New Task</span>
                </button>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT AREA -->
    <main class="flex-1 w-full">
        <div class="max-w-7xl mx-auto px-4 md:px-8 py-6 space-y-6">

            <!-- ALERT BANNER (now full-width under the topbar instead of inline) -->
            <div id="alertBox" class="hidden px-4 py-2.5 rounded-xl surface-card text-emerald-200 text-xs font-medium items-center gap-2 animate-fade-in">
                <i class="fa-solid fa-circle-check"></i> <span id="alertText">Task added successfully.</span>
            </div>

            <!-- OVERVIEW: stat cards + priority filter -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                <div class="surface-card rounded-2xl p-4 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">Total</p>
                        <h3 id="statTotal" class="text-xl font-bold mt-1 text-slate-50">0</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-black/15 border border-white/10 flex items-center justify-center text-slate-200">
                        <i class="fa-solid fa-clipboard-list text-sm"></i>
                    </div>
                </div>
                <div class="surface-card rounded-2xl p-4 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">Pending</p>
                        <h3 id="statPending" class="text-xl font-bold mt-1 text-amber-300">0</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-amber-400/10 border border-amber-300/20 flex items-center justify-center text-amber-300">
                        <i class="fa-solid fa-hourglass-half text-sm"></i>
                    </div>
                </div>
                <div class="surface-card rounded-2xl p-4 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">Completed</p>
                        <h3 id="statCompleted" class="text-xl font-bold mt-1 text-emerald-300">0</h3>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-400/10 border border-emerald-300/20 flex items-center justify-center text-emerald-300">
                        <i class="fa-solid fa-circle-check text-sm"></i>
                    </div>
                </div>

                <!-- Priority filter card, now part of the overview row instead of buried in the registry header -->
                <div class="surface-card rounded-2xl p-4 flex flex-col justify-center gap-2">
                    <p class="text-[10px] font-bold text-slate-300 uppercase tracking-wider">Filter Priority</p>
                    <select id="priorityFilter" onchange="renderTasks()" class="w-full surface-input px-3 py-1.5 rounded-lg text-xs font-medium">
                        <option value="all">All Priorities</option>
                        <option value="Urgent">Urgent</option>
                        <option value="Reminder">Reminder</option>
                    </select>
                </div>
            </div>

            <!-- TASK REGISTRY -->
            <div class="surface-card rounded-2xl p-6 space-y-4">
                <div class="flex items-center justify-between pb-4 border-b border-white/10">
                    <div class="flex items-center gap-2">
                        <h2 class="font-bold text-sm tracking-tight text-slate-50">Task Registry</h2>
                        <span id="registryFilterTag" class="text-[10px] px-2 py-0.5 rounded-full bg-black/20 text-slate-200 uppercase font-semibold">All Tasks</span>
                    </div>
                    <p class="text-xs text-slate-300 hidden sm:block">Manage, edit, and track your deliverables.</p>
                </div>

                <!-- Empty State -->
                <div id="emptyState" class="hidden py-12 text-center">
                    <div class="w-12 h-12 mx-auto mb-3 rounded-2xl surface-card flex items-center justify-center text-slate-300 text-sm">
                        <i class="fa-regular fa-folder-open"></i>
                    </div>
                    <h3 class="font-semibold text-xs uppercase tracking-wider text-slate-200">No tasks found</h3>
                    <p class="text-xs text-slate-400 mt-1">Click "New Task" above to create your first item.</p>
                </div>

                <!-- Task List Grid: now 3-column on wide screens since the sidebar no longer eats width -->
                <div id="taskGrid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-3">
                    <!-- Dynamic Items -->
                </div>
            </div>
        </div>
    </main>

    <footer class="w-full py-4 text-center text-[10px] text-slate-300/80">
        SHINJI's Task Manager &middot; Dashboard
    </footer>

    <!-- ADD/EDIT TASK MODAL POPUP -->
    <div id="taskModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-md hidden">
        <div class="surface-card rounded-2xl p-6 w-full max-w-xl shadow-2xl relative">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-white/10">
                <h3 id="modalTitle" class="font-bold text-sm text-slate-50 uppercase tracking-wider">Add Task</h3>
                <button onclick="closeModal()" class="w-7 h-7 rounded-lg btn-flat flex items-center justify-center text-slate-300 hover:text-white">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>

            <form id="taskForm" onsubmit="handleFormSubmit(event)" class="space-y-4">
                <input type="hidden" id="taskId">

                <div>
                    <label class="block text-[10px] font-bold text-slate-300 uppercase tracking-wider mb-1">Task Name</label>
                    <input type="text" id="taskTitle" required placeholder="Enter task name..." class="w-full surface-input px-3.5 py-2.5 rounded-xl text-xs font-medium">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-300 uppercase tracking-wider mb-1">Due Date</label>
                        <input type="date" id="taskDueDate" required class="w-full surface-input px-3.5 py-2.5 rounded-xl text-xs font-medium">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-300 uppercase tracking-wider mb-1">Priority</label>
                        <select id="taskPriority" class="w-full surface-input px-3.5 py-2.5 rounded-xl text-xs font-medium">
                            <option value="Reminder">Reminder</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-300 uppercase tracking-wider mb-1">Status</label>
                        <select id="taskStatusSelect" class="w-full surface-input px-3.5 py-2.5 rounded-xl text-xs font-medium">
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-300 uppercase tracking-wider mb-1">Description</label>
                    <textarea id="taskDesc" rows="3" placeholder="Enter task description..." class="w-full surface-input px-3.5 py-2.5 rounded-xl text-xs font-medium resize-none"></textarea>
                </div>

                <div class="flex items-center justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal()" class="btn-flat px-4 py-2 rounded-xl text-xs font-semibold text-slate-200">Cancel</button>
                    <button type="submit" id="submitBtn" class="btn-primary px-5 py-2 rounded-xl text-xs font-semibold">Save Task</button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPT ENGINE -->

   <script>
    // Bridge Laravel database records into your front-end JavaScript
    let tasks = @json($tasks);

    let currentFilter = 'all';
    let currentSearchQuery = '';

    window.onload = function() {
        const dueDateInput = document.getElementById('taskDueDate');
        if (dueDateInput) {
            dueDateInput.min = new Date().toISOString().split('T')[0];
        }
        renderApp();
    };

    function setFilter(filter) {
        currentFilter = filter;
        ['all', 'pending', 'completed'].forEach(f => {
            const btn = document.getElementById(`nav-${f}`);
            if (btn) {
                if (f === filter) {
                    btn.className = "flex-1 lg:flex-none flex items-center justify-center gap-2 px-3.5 py-2 rounded-lg text-xs font-medium tab-active transition-all";
                } else {
                    btn.className = "flex-1 lg:flex-none flex items-center justify-center gap-2 px-3.5 py-2 rounded-lg text-xs font-medium tab-inactive transition-all";
                }
            }
        });
        const filterTag = document.getElementById('registryFilterTag');
        if (filterTag) {
            filterTag.innerText = filter.charAt(0).toUpperCase() + filter.slice(1) + ' Tasks';
        }
        renderTasks();
    }

    function handleSearch() {
        const searchInput = document.getElementById('searchInput');
        currentSearchQuery = searchInput ? searchInput.value.toLowerCase().trim() : '';
        renderTasks();
    }

    function openModal(id = null) {
        const modal = document.getElementById('taskModal');
        if (!modal) return;
        modal.classList.remove('hidden');

        if (id) {
            const task = tasks.find(t => String(t.id) === String(id));
            if (!task) return;
            document.getElementById('modalTitle').innerText = 'Edit Task';
            document.getElementById('submitBtn').innerText = 'Update Task';
            document.getElementById('taskId').value = task.id;
            document.getElementById('taskTitle').value = task.title || '';
            document.getElementById('taskDesc').value = task.description || '';
            document.getElementById('taskPriority').value = task.priority || 'Reminder';
            document.getElementById('taskDueDate').value = task.due_date || task.dueDate || '';
            document.getElementById('taskStatusSelect').value = task.status ? task.status.toLowerCase() : 'pending';
        } else {
            document.getElementById('modalTitle').innerText = 'Add Task';
            document.getElementById('submitBtn').innerText = 'Save Task';
            document.getElementById('taskForm').reset();
            document.getElementById('taskId').value = '';
        }
    }

    function closeModal() {
        const modal = document.getElementById('taskModal');
        if (modal) modal.classList.add('hidden');
    }

    function showAlert(msg) {
        const alertBox = document.getElementById('alertBox');
        const alertText = document.getElementById('alertText');
        if (alertBox && alertText) {
            alertText.innerText = msg;
            alertBox.classList.remove('hidden');
            alertBox.classList.add('flex');
            setTimeout(() => { alertBox.classList.add('hidden'); alertBox.classList.remove('flex'); }, 3000);
        }
    }

    function renderApp() {
        updateStats();
        renderTasks();
    }

    function updateStats() {
        if (typeof tasks === 'undefined') return;
        const total = tasks.length;
        const pending = tasks.filter(t => (t.status || '').toLowerCase() === 'pending').length;
        const completed = tasks.filter(t => (t.status || '').toLowerCase() === 'completed').length;

        const setElementText = (id, val) => {
            const el = document.getElementById(id);
            if (el) el.innerText = val;
        };

        setElementText('statTotal', total);
        setElementText('statPending', pending);
        setElementText('statCompleted', completed);
        setElementText('badge-all', total);
        setElementText('badge-pending', pending);
        setElementText('badge-completed', completed);
    }

    function renderTasks() {
        if (typeof tasks === 'undefined') return;
        const priorityFilterEl = document.getElementById('priorityFilter');
        const priorityVal = priorityFilterEl ? priorityFilterEl.value : 'all';

        const filtered = tasks.filter(t => {
            const status = (t.status || '').toLowerCase();
            if (currentFilter !== 'all' && status !== currentFilter.toLowerCase()) return false;
            if (priorityVal !== 'all' && t.priority !== priorityVal) return false;
            if (currentSearchQuery &&
                !(t.title || '').toLowerCase().includes(currentSearchQuery) &&
                !(t.description || '').toLowerCase().includes(currentSearchQuery)) return false;
            return true;
        });

        const grid = document.getElementById('taskGrid');
        const emptyState = document.getElementById('emptyState');
        if (!grid || !emptyState) return;

        grid.innerHTML = '';

        if (filtered.length === 0) {
            emptyState.classList.remove('hidden');
            grid.classList.add('hidden');
            return;
        } else {
            emptyState.classList.add('hidden');
            grid.classList.remove('hidden');
        }

        filtered.forEach(task => {
            const isCompleted = (task.status || '').toLowerCase() === 'completed';
            const dueDateStr = task.due_date || task.dueDate || '';
            const card = document.createElement('div');
            card.className = "surface-card rounded-2xl p-4 flex flex-col justify-between transition-all hover:bg-white/5";
            card.innerHTML = `
                <div>
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="px-2 py-0.5 rounded-md text-[10px] font-semibold uppercase border ${task.priority === 'Urgent' ? 'border-rose-300/30 bg-rose-400/10 text-rose-200' : 'border-slate-300/30 bg-slate-400/10 text-slate-200'}">${escapeHtml(task.priority || 'Normal')}</span>
                        <span class="text-[10px] font-medium text-slate-300"><i class="fa-regular fa-calendar mr-1"></i>${escapeHtml(dueDateStr)}</span>
                    </div>
                    <h4 class="font-semibold text-xs tracking-tight mb-1 text-slate-50 ${isCompleted ? 'line-through opacity-50' : ''}">${escapeHtml(task.title || '')}</h4>
                    <p class="text-xs text-slate-300 font-normal line-clamp-2 leading-relaxed">${escapeHtml(task.description || 'No description provided.')}</p>
                </div>
                <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between">
                    <span class="inline-flex items-center gap-1.5 text-[10px] font-semibold uppercase tracking-wide ${isCompleted ? 'text-emerald-300' : 'text-amber-300'}">
                        <span class="w-1.5 h-1.5 rounded-full ${isCompleted ? 'bg-emerald-300' : 'bg-amber-300'}"></span>
                        ${isCompleted ? 'Completed' : 'Pending'}
                    </span>
                    <div class="flex items-center gap-1.5">
                        <button onclick="toggleStatus('${task.id}')" title="${isCompleted ? 'Reopen' : 'Complete'}" class="w-7 h-7 rounded-lg btn-flat flex items-center justify-center text-xs text-slate-200 hover:text-white">
                            <i class="fa-solid ${isCompleted ? 'fa-rotate-left' : 'fa-check'} text-[11px]"></i>
                        </button>
                        <button onclick="openModal('${task.id}')" title="Edit" class="w-7 h-7 rounded-lg btn-flat flex items-center justify-center text-xs text-slate-200 hover:text-white">
                            <i class="fa-solid fa-pen text-[10px]"></i>
                        </button>
                        <button onclick="deleteTask('${task.id}')" title="Delete" class="w-7 h-7 rounded-lg btn-flat flex items-center justify-center text-xs text-slate-200 hover:text-rose-300">
                            <i class="fa-solid fa-trash-can text-[10px]"></i>
                        </button>
                    </div>
                </div>
            `;
            grid.appendChild(card);
        });
        updateStats();
    }

    async function handleFormSubmit(e) {
        e.preventDefault();
        const id = document.getElementById('taskId').value;
        const title = document.getElementById('taskTitle').value.trim();
        const description = document.getElementById('taskDesc').value.trim();
        const priority = document.getElementById('taskPriority').value;
        const due_date = document.getElementById('taskDueDate').value;
        const status = document.getElementById('taskStatusSelect').value;

        if (!title || !due_date) return;

        const formData = { title, description, priority, due_date, status };
        const url = id ? `/tasks/${id}` : '/tasks';
        const method = id ? 'PUT' : 'POST';

        try {
            let response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(formData)
            });

            if (response.ok) {
                showAlert(id ? 'Task updated successfully.' : 'Task added successfully.');
                closeModal();
                location.reload();
            } else {
                const errorData = await response.json();
                console.error('Validation Errors:', errorData);

                let message = 'Failed to save task.';
                if (errorData.errors) {
                    message += ' ' + Object.values(errorData.errors).flat().join(' ');
                } else if (errorData.message) {
                    message += ' ' + errorData.message;
                }
                alert(message);
            }
        } catch (error) {
            console.error('Error:', error);
            alert('An unexpected network error occurred.');
        }
    }

    async function toggleStatus(id) {
        try {
            let response = await fetch(`/tasks/${id}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (response.ok) {
                location.reload();
            } else {
                alert('Failed to update status.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    async function deleteTask(id) {
        if (!confirm('Are you sure you want to delete this task?')) return;

        try {
            let response = await fetch(`/tasks/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            if (response.ok) {
                showAlert('Task deleted.');
                location.reload();
            } else {
                alert('Failed to delete task.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }
</script>
</body>
</html>