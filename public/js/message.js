const infoFlashMessage = (message) => {
    $("#flashMessages").append(
        `<div class="alert alert-info alert-dismissible fade show m-0" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`
    );
};
