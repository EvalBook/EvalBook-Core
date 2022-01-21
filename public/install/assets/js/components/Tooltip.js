
export const Tooltip = function(text) {

    // Positions margins.
    this.posXMargin = 10;
    this.posYMargin = 16;

    // Defining tooltip container.
    this.container = document.createElement('div');
    this.container.innerHTML = text;
    this.container.className = 'tooltip';
    this.container.style.display = 'none';
    document.body.append(this.container);

    document.body.addEventListener('mousemove', (e) => {
        if(this.container.style.display !== 'none') {
            this.container.style.left = (e.pageX + this.posXMargin) + 'px';
            this.container.style.top = (e.pageY + this.posYMargin) + 'px';
        }
    });

    /**
     * Show tooltip
     * @param mouseEvent MouseEvent
     */
    this.show = function(mouseEvent) {
        if(mouseEvent instanceof MouseEvent) {
            this.container.style.display = 'block';
        }
        else {
            throw Error("Tooltip.show() should have MouseEvent as argument, " + typeof mouseEvent + " given");
        }
    };

    /**
     * Hide tooltip.
     */
    this.hide = function() {
        this.container.style.display = 'none';
        this.container.style.left = 0;
        this.container.style.top = 0;
    };
}