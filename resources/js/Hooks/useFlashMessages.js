import {reactive} from "vue";

export default function useFlashMessages() {
    const messages = reactive([]);

    const show = (text) => {
        messages.push({
            id: Date.now(),
            text: text
        });

        setTimeout(() => {
            messages.shift();
        }, 3000);
    }

    return {
        messages,
        show
    }
}
