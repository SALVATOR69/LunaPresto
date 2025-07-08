/**
 * This script uses the Intersection Observer API to add a 'visible' class
 * to elements with the 'reveal-on-scroll' class when they enter the viewport.
 * It also uses a MutationObserver to handle dynamically loaded content.
 */
document.addEventListener('DOMContentLoaded', () => {
    const observerOptions = {
        root: null, // Use the viewport as the root
        threshold: 0.1 // Trigger when 10% of the element is visible
    };

    // The IntersectionObserver that adds the 'visible' class
    const revealObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            // Toggle the 'visible' class based on whether the element is intersecting
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            } else {
                // Element is not in view, remove the class to trigger the exit animation
                entry.target.classList.remove('visible');
            }
        });
    }, observerOptions);

    // Function to find and observe all revealable elements on the page
    const observeElements = (container) => {
        const revealElements = container.querySelectorAll('.reveal-on-scroll');
        revealElements.forEach(element => revealObserver.observe(element));
    };

    // Initial run to catch all static elements
    observeElements(document);

    // Use a MutationObserver to catch dynamically loaded elements (like in the header)
    const mutationObserver = new MutationObserver((mutations) => {
        for (const mutation of mutations) {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1) { // Check if it's an element
                        observeElements(node);
                    }
                });
            }
        }
    });

    // Start observing the entire body for changes that add new nodes
    mutationObserver.observe(document.body, { childList: true, subtree: true });
});