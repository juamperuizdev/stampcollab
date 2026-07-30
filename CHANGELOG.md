# STAMPCOLLAB - CHANGELOG

## 0.0.4 (2026-07-30)

- Upgrades in sending mails.

## 0.0.3 (2026-07-29)

- Anonymised webmaster email to `.env` via `email.webmasterMail` config property
- New `about/` frontend page with project info, privacy policy and author credits
- Email notification via Brevo SMTP when a stamp is uploaded from the frontend
- New `mail/stamp_notification` email template with journal name, thumbnail, IP and user agent
- Test Email button in backend menu to verify SMTP configuration
- Font Awesome added to frontend assets

## 0.0.2 (2026-07-28)

- Collaborative upload of stamps in the frontend
- Save the stamps to public/uploads/
- Webp thumbs from the image uploaded
- Save the stamp to the database
- Dinamic treatment of the journals

## 0.0.1 (2026-07-25)

- Codeigniter `4.7.4` framework
- Backend with crud: 
    - Administrators
    - Journals
    - Stamps

## 0.0.0 (2026-07-03)

- Initial release
- Codeigniter `4.7.3` framework