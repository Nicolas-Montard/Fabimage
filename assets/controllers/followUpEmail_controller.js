import { Controller } from '@hotwired/stimulus';
import { useStimulusTrait } from '@symfony/stimulus-bridge';

export default class extends Controller {
    static targets = ['collection'];

    connect() {
        useStimulusTrait(this);
    }

    addItem(event) {
        event.preventDefault();

        const collectionHolder = this.collectionTarget;
        const item = document.createElement('div');
        item.innerHTML = collectionHolder.dataset.prototype.replace(/__name__/g, collectionHolder.dataset.index);

        collectionHolder.appendChild(item);
        collectionHolder.dataset.index++;
    }

    removeItem(event) {
        event.preventDefault();
        event.target.closest('.form-group').remove();
    }
}