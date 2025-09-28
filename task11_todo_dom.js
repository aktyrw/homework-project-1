(() => {
    // Элементы UI
    const listEl = document.getElementById("list");
    const addForm = document.getElementById("addForm");
    const taskInput = document.getElementById("taskInput");
    const prioritySelect = document.getElementById("prioritySelect");
    const sortSelect = document.getElementById("sortSelect");
    const filterSelect = document.getElementById("filterSelect");
    const clearCompletedBtn = document.getElementById("clearCompleted");
  
    // Состояние (храним и в localStorage)
    let tasks = load();
  
    const prRank = { high: 3, medium: 2, low: 1 };
  
    function save() {
      localStorage.setItem("task11_tasks", JSON.stringify(tasks));
    }
    function load() {
      try {
        return JSON.parse(localStorage.getItem("task11_tasks") || "[]");
      } catch {
        return [];
      }
    }
  
    // Добавление
    addForm.addEventListener("submit", (e) => {
      e.preventDefault();
      const title = taskInput.value.trim();
      if (!title) return;
  
      tasks.push({
        id: crypto.randomUUID ? crypto.randomUUID() : String(Math.random()),
        title,
        priority: prioritySelect.value,
        status: "pending",
        createdAt: Date.now()
      });
  
      taskInput.value = "";
      save();
      render();
    });
  
    // Сортировка/фильтр/кнопки
    sortSelect.addEventListener("change", render);
    filterSelect.addEventListener("change", render);
  
    clearCompletedBtn.addEventListener("click", () => {
      tasks = tasks.filter(t => t.status !== "completed");
      save();
      render();
    });
  
    // Рендер списка
    function render() {
      listEl.innerHTML = "";
  
      // 1) фильтр
      let view = tasks.slice();
      if (filterSelect.value === "pending") {
        view = view.filter(t => t.status === "pending");
      } else if (filterSelect.value === "completed") {
        view = view.filter(t => t.status === "completed");
      }
  
      // 2) сортировка
      switch (sortSelect.value) {
        case "created_desc":
          view.sort((a,b) => b.createdAt - a.createdAt); break;
        case "created_asc":
          view.sort((a,b) => a.createdAt - b.createdAt); break;
        case "priority_desc":
          view.sort((a,b) => prRank[b.priority] - prRank[a.priority]); break;
        case "priority_asc":
          view.sort((a,b) => prRank[a.priority] - prRank[b.priority]); break;
        case "title_asc":
          view.sort((a,b) => a.title.localeCompare(b.title)); break;
        case "title_desc":
          view.sort((a,b) => b.title.localeCompare(a.title)); break;
      }
  
      // 3) отрисовка
      for (const t of view) {
        const li = document.createElement("li");
        li.className = "item" + (t.status === "completed" ? " done" : "");
        li.setAttribute("data-id", t.id);
  
        // чекбокс
        const cb = document.createElement("input");
        cb.type = "checkbox";
        cb.checked = t.status === "completed";
        cb.ariaLabel = "Отметить выполненной";
        cb.addEventListener("change", () => {
          t.status = cb.checked ? "completed" : "pending";
          save();
          render();
        });
  
        // заголовок + мета
        const center = document.createElement("div");
        const title = document.createElement("div");
        title.className = "title";
        title.textContent = t.title;
  
        const meta = document.createElement("div");
        meta.className = "meta";
        const dt = new Date(t.createdAt);
        meta.textContent = `создано: ${dt.toLocaleString()}`;
  
        center.append(title, meta);
  
        // приоритет
        const pill = document.createElement("span");
        pill.className = `pill ${t.priority}`;
        pill.textContent = t.priority;
  
        // кнопки действий
        const actions = document.createElement("div");
        const editBtn = document.createElement("button");
        editBtn.className = "icon-btn";
        editBtn.type = "button";
        editBtn.title = "Редактировать название";
        editBtn.textContent = "✏️";
        editBtn.addEventListener("click", () => {
          const newTitle = prompt("Изменить название задачи:", t.title);
          if (newTitle !== null) {
            const v = newTitle.trim();
            if (v) {
              t.title = v;
              save();
              render();
            }
          }
        });
  
        const delBtn = document.createElement("button");
        delBtn.className = "icon-btn";
        delBtn.type = "button";
        delBtn.title = "Удалить";
        delBtn.textContent = "🗑️";
        delBtn.addEventListener("click", () => {
          tasks = tasks.filter(x => x.id !== t.id);
          save();
          render();
        });
  
        actions.append(editBtn, delBtn);
  
        li.append(cb, center, pill, actions);
        listEl.appendChild(li);
      }
    }
  
    // Первый рендер
    render();
  })();