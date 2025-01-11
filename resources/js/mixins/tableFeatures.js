export default function tableFeatures() {
    return {
        activeRow: null,
        activeIndex: 0,
        rows: [],
        
        // Temel özellikler
        init() {
            this.initRows();
            this.setupWatchers();
            this.setupEventListeners();
        },
        
        // Row yönetimi
        initRows() {
            this.rows = [...this.$el.querySelectorAll('tbody tr[data-id]')];
            if (this.rows.length > 0 && !this.activeRow) {
                this.activeIndex = 0;
                this.activeRow = this.rows[0].getAttribute('data-id');
                this.rows[0].focus();
            }
        },

        // Event listeners
        setupEventListeners() {
            // Modal events
            Livewire.on('closeModal', () => this.handleModalClose());
            Livewire.on('focusRow', (rowId) => this.handleRowFocus(rowId));
        },

        // Event handlers
        handleModalClose() {
            this.initRows();
            if (this.rows.length > 0) {
                if (!this.activeRow) {
                    this.activeIndex = 0;
                    this.activeRow = this.rows[0].getAttribute('data-id');
                }
                const activeRowElement = this.rows.find(row => row.getAttribute('data-id') === this.activeRow);
                if (activeRowElement) {
                    activeRowElement.focus();
                } else {
                    this.rows[0].focus();
                }
            }
        },

        handleRowFocus(rowId) {
            this.$nextTick(() => {
                this.initRows();
                const newRow = this.rows.find(row => row.getAttribute('data-id') === rowId.toString());
                if (newRow) {
                    this.activeRow = rowId.toString();
                    this.activeIndex = this.rows.indexOf(newRow);
                    newRow.focus();
                }
            });
        },
        
        // Watchers
        setupWatchers() {
            this.$watch('activeRow', value => {
                this.rows.forEach(row => {
                    if (row.getAttribute('data-id') === value) {
                        row.classList.add('bg-blue-50');
                    } else {
                        row.classList.remove('bg-blue-50');
                    }
                });
            });
        },
        
        // Keyboard navigation
        handleKeyDown(event) {
            switch(event.key) {
                case 'ArrowDown':
                    event.preventDefault();
                    this.navigateDown();
                    break;
                case 'ArrowUp':
                    event.preventDefault();
                    this.navigateUp();
                    break;
                case 'Enter':
                    event.preventDefault();
                    this.handleEnter();
                    break;
            }
        },

        navigateDown() {
            if (this.activeIndex < this.rows.length - 1) {
                this.activeIndex++;
                this.activeRow = this.rows[this.activeIndex].getAttribute('data-id');
                this.rows[this.activeIndex].focus();
            }
        },

        navigateUp() {
            if (this.activeIndex > 0) {
                this.activeIndex--;
                this.activeRow = this.rows[this.activeIndex].getAttribute('data-id');
                this.rows[this.activeIndex].focus();
            }
        },

        handleEnter() {
            if (this.activeRow) {
                this.$wire.handleEditRow(this.activeRow);
            }
        },

        // Row interactions
        handleRowClick(id, index) {
            this.activeRow = id;
            this.activeIndex = index;
        },

        handleRowDoubleClick(id) {
            this.$wire.handleEditRow(id);
        }
    };
} 