/**
 * @param {Object} config
 * @param {string} config.selector   CSS selector for trigger elements
 * @param {string} config.message    Confirmation message
 * @param {Function} [config.onConfirm]  Called when user confirms
 * @param {Function} [config.onCancel]   Called when user cancels
 */
function makeConfirmable(config) {
  if (!config || !config.selector || !config.message) {
    console.error('makeConfirmable requires selector and message');
    return;
  }

  document.querySelectorAll(config.selector).forEach((el) => {
    el.addEventListener('click', (event) => {
      const confirmed = window.confirm(config.message);

      if (!confirmed) {
        event.preventDefault();

        if (typeof config.onCancel === 'function') {
          config.onCancel(event, el);
        }
      } else if (typeof config.onConfirm === 'function') {
        config.onConfirm(event, el);
      }
    });
  });
}

window.makeConfirmable = makeConfirmable;
