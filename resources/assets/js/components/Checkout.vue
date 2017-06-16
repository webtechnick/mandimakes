<template>
    <div>
        <button type="submit" @click="open">Pay with Card</button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                'key': document.head.querySelector('meta[name="csrf-token"]').content
            };
        },
        methods: {
            open() {

            }
        }
    }
</script>
