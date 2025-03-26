# Monaco Editor Integration in Laravel

This project uses Monaco Editor for code editing in challenge tasks. 

## Setup Instructions

1. Install the Monaco Editor package:
   ```bash
   npm install monaco-editor
   ```

2. Install the fs-extra package (used by the publish script):
   ```bash
   npm install fs-extra
   ```

3. Run the publish script to copy Monaco Editor files to the public directory:
   ```bash
   npm run publish-monaco
   ```

4. Check that the Monaco Editor files are in `public/js/monaco-editor/`.

## How it Works

The Monaco Editor integration consists of:

1. **Editor Loading**: The editor is loaded from local files instead of CDN in the layout file.

2. **Editor Initialization**: The editor is initialized in the task.blade.php file with proper settings for syntax highlighting based on the challenge's programming language.

3. **Code Execution**: The editor sends code to the backend API for execution.

4. **Solution Submission**: Completed solutions are submitted for evaluation.

## Customization

You can modify the Monaco Editor configuration in the `task.blade.php` file:

- **Theme**: Change the editor theme (vs-dark, vs, hc-black)
- **Font Size**: Adjust the editor font size
- **Line Numbers**: Enable/disable line numbers
- **Minimap**: Enable/disable the minimap

## Updating

To update to a newer version of Monaco Editor:

1. Update the package:
   ```bash
   npm install monaco-editor@latest
   ```

2. Run the publish script again:
   ```bash
   npm run publish-monaco
   ```

## Troubleshooting

If you encounter issues with the editor:

- Check browser console for errors
- Ensure Monaco Editor files are properly published to the public directory
- Verify that the layout file includes the necessary Monaco Editor scripts
- Make sure the CSRF token is properly set for API requests 