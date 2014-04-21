# PhpED Integration Scripts #

Integration scripts for NuSphere's PhpED IDE.

Note that I'm not the author of most/any of these scripts - I'm merely a curator - though I have modified a few of them to suit my preferences/requirements.

## CreateGetSet.php ##
Creates "getter" and "setter" methods for the currently-selected class members.

** Configuration: **
- **Execute with**: Shell
- **Command line**: `C:\Path\To\php.exe -q "C:\Path\To\php-integration-scripts\CreateGetSet.php"`
- **Filter**
    - **Filter by file extension(s)**: `*.php` *(or whatever extensions you use for PHP class files)*
- **Show this command in Tools menu** :ballot_box_with_check:
- **Show this command in File Bar popup** :ballot_box_with_check:
- **Work with editor** :ballot_box_with_check:
    - **Take input from** :ballot_box_with_check:
        - **Selected text** :ballot_box_with_check:
    - **Return results to editor**

## AlignEquals.php ##
Align the rightmost equal signs in the selected text. Useful for formatting assignment lists and/or array assignments. 

** Configuration: **
- **Execute with**: Shell
- **Command line**: `C:\Path\To\php.exe -q "C:\Path\To\php-integration-scripts\AlignEquals.php"`
- **Show this command in Tools menu** :ballot_box_with_check:
- **Show this command in File Bar popup** :ballot_box_with_check:
- **Work with editor** :ballot_box_with_check:
    - **Take input from** :ballot_box_with_check:
        - **Selected text** :ballot_box_with_check:
    - **Return results to editor**

## WrapLines.php ##
Wordwrap the selected text to the given right margin. Keeps the existing right indent and comment prefix. Removes all extra whitespace, so it is only suitable for plain text, not code samples and such. 

** Configuration: **
- **Execute with**: Shell
- **Command line**: `C:\Path\To\php.exe -q "C:\Path\To\php-integration-scripts\WrapLines.php" 120` *(change `120` to your desired line length)*
- **Show this command in Tools menu** :ballot_box_with_check:
- **Show this command in File Bar popup** :ballot_box_with_check:
- **Work with editor** :ballot_box_with_check:
    - **Take input from** :ballot_box_with_check:
        - **Selected text** :ballot_box_with_check:
    - **Return results to editor**
