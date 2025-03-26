.then(response => {
    const responseData = response.data;
    
    if (responseData.is_correct) {
        // Show success message
        showMessage('Solution submitted successfully!');
    } else {
        // Show error message
        showMessage(responseData.message);
    }
    
    // Handle redirect if provided
    if (responseData.redirect) {
        setTimeout(() => {
            window.location.href = responseData.redirect;
        }, 2000); // Short delay before redirect
    }
}) 