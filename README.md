# Quick SSH (QSSH)

QuickSSH is a command line tool that allows you to save named SSH connections and
connect to them quickly by name. Think of QuickSSH as a simple SSH credential manager.

### Pre-requisites

QuickSSH requires PHP 7.4+ to be installed and included in your `PATH`.

### Installation

1. Download the release.
2. Extract the archive into a folder on your system. Somewhere like `C:\Program Files\qssh`
3. Add the path to the QSSH `bin` folder to your systems `PATH` (ie. `C:\Program Files\qssh\bin`)
4. Check QuickSSH is installed correctly by opening a new terminal and running `qssh --version`

### Usage

| Command                         | Description                 |
|---------------------------------|-----------------------------|
| `qssh set <name> <user>@<host>` | Saves a new named server    |
| `qssh <name>`                   | Connects to a named server  |
| `qssh list`                     | Lists all saved servers     |
| `qssh unset <name>`             | Removes a named server      |

**Examples**:

Save an SSH connection named `msdev`:
```
qssh set msdev root@dev.mysite.com
```

Connect to the saved server:
```
qssh msdev
```

List all saved servers:
```
qssh list
```

Removes the named server from the list:
```
qssh unset msdev
```