    'use strict';

    const $_TOAST_POSITION_TOP_RIGHT = "topRight";
    const $_TOAST_POSITION_BOTTOM_RIGHT = "bottomRight";
    const $_TOAST_POSITION_TOP_LEFT = "topLeft";
    const $_TOAST_POSITION_BOTTOM_LEFT = "bottomLeft";
    const $_TOAST_POSITION_TOP_CENTER = "topCenter";
    const $_TOAST_POSITION_BOTTOM_CENTER = "bottomCenter";

    /**
     * iziToast object
     */
    const $_IZI_TOAST = {
        message: '',
        cssClass: '',
        icon: '',
        image: '',
        position: $_TOAST_POSITION_TOP_RIGHT,
        instance({message, cssClass, icon, position}) {
            this.message = message;
            this.cssClass = cssClass;
            this.icon = icon;
            this.position = position || $_TOAST_POSITION_TOP_RIGHT;
            return this;
        },
        instanceImg({message, cssClass, image, position}) {
            this.message = message;
            this.cssClass = cssClass;
            this.image = image;
            this.position = position || $_TOAST_POSITION_TOP_RIGHT;
            return this;
        }
    };

    /**
     * Success izziToast notification
     * @param message - Display message
     * @param position - Position of the notification
     */
    const iziToastSuccess = ({message, position = null}) => {
        const cssClass = "iziToast iziToast-success";
        const icon = "fas fa-check-circle";
        const iziToastData = {...$_IZI_TOAST.instance({message: message, cssClass: cssClass, icon: icon, position: position})};
        iziToastShow(iziToastData);
    }

    /**
     * Error izziToast notification
     * @param message - Display message
     * @param position - Position of the notification
     */
    const iziToastError = ({message, position = null}) => {
        const cssClass = "iziToast iziToast-danger";
        const icon = "fas fa-exclamation-circle";
        const iziToastData = {...$_IZI_TOAST.instance({message: message, cssClass: cssClass, icon: icon, position: position})};
        iziToastShow(iziToastData);
    }

    /**
     * izziToast (with image) notification
     * @param image - Image to display
     * @param message - Display message
     * @param position - Position of the notification
     * @param css - Custom CSS class for the notification
     */
    const iziToastWithImage = ({image, message, position = null, css = null}) => {
        const cssClass = css || 'iziToast iziToast-dark';
        const iziToastData = {...$_IZI_TOAST.instanceImg({message: message, cssClass: cssClass, image: image, position: position})};
        iziToastShow(iziToastData);
    }

    /**
     * izziToast (with image base64) notification
     * @param image - Base64 image to display
     * @param message - Display message
     * @param position - Position of the notification
     * @param css - Custom CSS class for the notification
     */
    const iziToastWithImageBase64 = ({image, message, position = null, css = null}) => {
        const cssClass = css || 'iziToast iziToast-dark';
        const imgB64 = 'data:image/png;base64,' + image;
        const iziToastData = {...$_IZI_TOAST.instanceImg({message: message, cssClass: cssClass, image: imgB64, position: position})};
        iziToastShow(iziToastData);
    }

    /**
     * Show izziToast notification
     * @param {Object} iziToastData - iziToast data object
     */
    const iziToastShow = (iziToastData) => {
        let iToastPosition = "";
        let iToastTransitionIn = "";
        switch (iziToastData.position) {
            case $_TOAST_POSITION_TOP_RIGHT:
                iToastPosition = "topRight";
                iToastTransitionIn = "fadeInLeft";
                break;
            case $_TOAST_POSITION_BOTTOM_RIGHT:
                iToastPosition = "bottomRight";
                iToastTransitionIn = "fadeInLeft";
                break;
            case $_TOAST_POSITION_TOP_LEFT:
                iToastPosition = "topLeft";
                iToastTransitionIn = "fadeInRight";
                break;
            case $_TOAST_POSITION_BOTTOM_LEFT:
                iToastPosition = "bottomLeft";
                iToastTransitionIn = "fadeInRight";
                break;
            case $_TOAST_POSITION_TOP_CENTER:
                iToastPosition = "topCenter";
                iToastTransitionIn = "fadeInDown";
                break;
            case $_TOAST_POSITION_BOTTOM_CENTER:
                iToastPosition = "bottomCenter";
                iToastTransitionIn = "fadeInUp";
                break;
            /*default:
                iToastPosition = "topRight";
                iToastTransitionIn = "fadeInLeft";*/
        }

        const iToast = {
            class: iziToastData.cssClass || '',
            title: iziToastData.title || '',
            message: iziToastData.message,
            position: iToastPosition,
            animateInside: true,
            progressBar: false,
            close: false,        
            icon: iziToastData.icon || '',
            timeout: 3200,
            transitionIn: iToastTransitionIn,
            transitionOut: 'fadeOut',
            transitionInMobile: 'fadeIn',
            transitionOutMobile: 'fadeOut'
        };
        
        if(iziToastData.image !== '') {
            iToast.image = iziToastData.image;
        }
        
        iziToast.show(iToast);
    }