# Security Policy

> This project follows the [Zairakai Global Security Policy][handbook-security].  
> Please refer to it for standard protections, response timeline, and contact information.

---

## 🔒 Reporting Vulnerabilities

| Channel | Description | Contact / Link |
| :--- | :--- | :--- |
| **GitLab Issues** | For non-sensitive issues (bugs, public vulnerabilities). | Open a confidential issue |
| **Email** | Alternative secure contact. | `security@the-white-rabbits.fr` |

Please **do not disclose vulnerabilities publicly** until they have been reviewed.

---

## 🛡️ Security Features

| Layer | Security Protection |
| :--- | :--- |
| **Static Analysis** | PHPStan Level Max + Rector modernizations |
| **Git Hooks** | Quality enforcement pre-commit / pre-push |
| **CI Pipeline** | Automated secret detection + ShellCheck |
| **Secrets** | `.env` never committed — `.env.example` sans valeurs sensibles |

---

[handbook-security]: https://gitlab.com/zairakai/handbook/-/blob/main/SECURITY.md
