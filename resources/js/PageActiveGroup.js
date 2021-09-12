import { LocalStorage } from 'typesafe-local-storage';


export const setCurrentActiveGroupFromWindow = () => {
    if (window.activeGroup) {
        LocalStorage.set('active_group', window.activeGroup.route);
    }
};

export const setActiveGroup = (route) => {
    if (route.trim() === '') {
        return;
    }
    LocalStorage.set('active_group', route);
};

export const getActiveGroup = () => {
    return LocalStorage.get('active_group', {
        title : 'Prologue',
        route : '2.0/prologue'
    });
};

export const createActiveGroupEventListener = () => {

    LocalStorage.onChange('active_group', (oldValue, newValue) => {

        for (let element of document.getElementsByClassName("item-group-title")) {

            if (!element?.dataset?.group) {
                continue;
            }

            if (element.dataset.group === newValue) {
                if (!element.classList.contains('active')) {
                    element.click();
                }
            } else {
                if (element.classList.contains('active')) {
                    element.click();
                }
            }
        }
    });
};

