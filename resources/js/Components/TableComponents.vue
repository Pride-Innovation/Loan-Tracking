<script setup>
defineProps({
  rows: {
    type: Number,
    default: 5
  },
  columns: {
    type: Number,
    default: 5
  },
  headerEnabled: {
    type: Boolean,
    default: true
  },
  columnWidths: {
    type: Array,
    default: () => []
  },
  columnNames: {
    type: Array,
    default: () => []
  }
});
</script>

<template>
  <div>
    <!-- Main Table Component -->
    <div class="overflow-x-auto md:overflow-x-visible">
      <table class="min-w-full border-separate border-spacing-0 rounded-lg border border-gray-300">
        <slot></slot>
      </table>
    </div>
  </div>
</template>

<script>
// Separate components for table parts
export const TableHead = {
  render() {
    return h('thead', { class: 'bg-[#08796c] text-white' }, this.$slots.default());
  }
};

export const TableHeader = {
  props: {
    align: {
      type: String,
      default: 'left'
    },
    className: {
      type: String,
      default: ''
    }
  },
  render() {
    return h('th', {
      scope: 'col',
      class: `sticky top-0 z-10 border border-gray-300 py-3.5 px-4 text-${this.align} text-sm font-semibold whitespace-normal ${this.className}`
    }, this.$slots.default());
  }
};

export const TableBody = {
  props: {
    className: {
      type: String,
      default: ''
    }
  },
  render() {
    return h('tbody', {
      class: `[&>*:nth-child(odd)]:bg-gray-50 ${this.className}`
    }, this.$slots.default());
  }
};

export const TableRow = {
  props: {
    onClick: {
      type: Function,
      default: null
    },
    className: {
      type: String,
      default: ''
    }
  },
  render() {
    return h('tr', {
      onClick: this.onClick,
      class: `${this.onClick ? 'cursor-pointer hover:bg-gray-100' : ''} ${this.className}`
    }, this.$slots.default());
  }
};

export const TableCell = {
  props: {
    align: {
      type: String,
      default: 'left'
    },
    className: {
      type: String,
      default: ''
    },
    as: {
      type: String,
      default: 'td'
    }
  },
  render() {
    return h(this.as, {
      class: `border border-gray-300 py-4 px-4 text-sm font-normal whitespace-normal text-${this.align} ${this.className}`
    }, this.$slots.default());
  }
};

export const TableSkeleton = {
  props: ['rows', 'columns', 'headerEnabled', 'columnWidths', 'columnNames'],
  render() {
    // Implementation of skeleton rendering
    // This would need to be implemented with the h function
  }
};
</script>
