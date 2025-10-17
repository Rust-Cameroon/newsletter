document.addEventListener("DOMContentLoaded", function() {
    fetch('./speakers.json')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('speakers-container');
            data.forEach(speaker => {
                const card = document.createElement('div');
                card.className = 'speaker-card';

                const photo = document.createElement('img');
                photo.className = 'speaker-photo';
                photo.src = speaker.Photo || './pictures/default.jpg';
                photo.alt = speaker.Name;

                const info = document.createElement('div');
                info.className = 'speaker-info';

                const name = document.createElement('div');
                name.className = 'speaker-name';
                name.textContent = speaker.Name;

                const title = document.createElement('div');
                title.className = 'speaker-title';
                title.innerHTML = `${speaker.Title || ''} ${speaker.Company ? 'at <a href="' + speaker.Social.Company + '" target="_blank">' + speaker.Company + '</a>' : ''}`;

                const social = document.createElement('div');
                social.className = 'speaker-social';
                if (speaker.Social.LinkedIn) {
                    const linkedIn = document.createElement('a');
                    linkedIn.href = speaker.Social.LinkedIn;
                    linkedIn.target = '_blank';
                    linkedIn.innerHTML = '<i class="fab fa-linkedin"></i> LinkedIn';
                    social.appendChild(linkedIn);
                }

                info.appendChild(name);
                info.appendChild(title);
                info.appendChild(social);
                card.appendChild(photo);
                card.appendChild(info);
                container.appendChild(card);
            });
        })
        .catch(error => console.error('Error loading speakers:', error));
});