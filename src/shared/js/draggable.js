(function (window, document) {
  /**
   * @param {string} containerSelector — CSS selector for the parent element
   * @param {string} itemSelector      — CSS selector for draggable items within the container
   */
  function DraggableGrid(containerSelector, itemSelector) {
    this.container = document.querySelector(containerSelector);
    this.itemSelector = itemSelector;
    this.draggedEl = null;

    if (!this.container) {
      throw new Error('DraggableGrid: container not found: ' + containerSelector);
    }

    this._bindEvents();
  }

  DraggableGrid.prototype._bindEvents = function () {
    this.container.addEventListener('dragstart', this._onDragStart.bind(this), false);
    this.container.addEventListener('dragend', this._onDragEnd.bind(this), false);
    this.container.addEventListener('dragover', this._onDragOver.bind(this), false);
    this.container.addEventListener('drop', this._onDrop.bind(this), false);
  };

  DraggableGrid.prototype._onDragStart = function (e) {
    const item = e.target.closest(this.itemSelector);

    if (!item) {
      return;
    }

    this.draggedEl = item;
    item.style.opacity = '0.5';

    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/plain', '');
  };

  DraggableGrid.prototype._onDragEnd = function () {
    if (this.draggedEl) {
      this.draggedEl.style.opacity = '1';
      this.draggedEl = null;
    }
  };

  DraggableGrid.prototype._onDragOver = function (e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
  };

  DraggableGrid.prototype._onDrop = function (e) {
    e.preventDefault();
    const target = e.target.closest(this.itemSelector);

    if (!this.draggedEl || !target || target === this.draggedEl) {
      return;
    }

    const children = Array.from(this.container.children);
    const dragIndex = children.indexOf(this.draggedEl);
    const targetIndex = children.indexOf(target);

    if (dragIndex < targetIndex) {
      this.container.insertBefore(this.draggedEl, target.nextSibling);
    } else {
      this.container.insertBefore(this.draggedEl, target);
    }
  };

  window.DraggableGrid = DraggableGrid;
})(window, document);
