// 摘要打字效果
document.addEventListener("DOMContentLoaded", function() {
    const typingSpeed = 60; // 每个字符之间的间隔时间，单位为毫秒
    const elements = document.querySelectorAll('.PandaAI-explanation');

    elements.forEach(function(element) {
        const summary = element.dataset.summary;
        const tagElement = element.closest('.post-PandaAI')?.querySelector('.PandaAI-tag');
        const cursor = element.querySelector('.blinking-cursor');

        if (!summary || !tagElement || !cursor) return;

        let i = 0;
        const textNode = document.createTextNode('');
        element.insertBefore(textNode, cursor); // 将文本节点插入到光标之前

        const typeWriter = setInterval(() => {
            if (i < summary.length) {
                textNode.nodeValue += summary.charAt(i);
                i++;
            } else {
                clearInterval(typeWriter);
                tagElement.classList.remove('loadingAI');
                element.removeChild(cursor); // 移除闪烁光标
            }
        }, typingSpeed);
    });
});