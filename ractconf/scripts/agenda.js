document.addEventListener("DOMContentLoaded", function() {
    fetch('./data/agenda.json')
        .then(response => response.json())
        .then(agendaData => {
            fetch('./speakers.json')
                .then(response => response.json())
                .then(speakersData => {
                    const agendaContainer = document.getElementById('agenda-container');
                    Object.keys(agendaData).forEach(day => {
                        const dayData = agendaData[day];
                        const daySection = document.createElement('div');
                        daySection.className = 'agenda-day';

                        const dayTitle = document.createElement('h2');
                        dayTitle.textContent = day;
                        daySection.appendChild(dayTitle);

                        const theme = document.createElement('p');
                        theme.className = 'agenda-theme';
                        theme.textContent = dayData.theme;
                        daySection.appendChild(theme);

                        dayData.sessions.forEach(session => {
                            const sessionDiv = document.createElement('div');
                            sessionDiv.className = 'agenda-session';

                            const time = document.createElement('div');
                            time.className = 'session-time';
                            time.textContent = session.time;
                            sessionDiv.appendChild(time);

                            const details = document.createElement('div');
                            details.className = 'session-details';

                            const sessionTitle = document.createElement('h3');
                            sessionTitle.textContent = session.session;
                            details.appendChild(sessionTitle);

                            const context = document.createElement('p');
                            context.textContent = session.context;
                            details.appendChild(context);

                            const speakerContainer = document.createElement('div');
                            speakerContainer.className = 'session-speakers';

                            session.speakers.forEach(speakerName => {
                                const speaker = speakersData.find(s => s.Name === speakerName);
                                if (speaker) {
                                    const speakerCard = document.createElement('div');
                                    speakerCard.className = 'speaker-card';

                                    const photo = document.createElement('img');
                                    photo.className = 'speaker-photo';
                                    photo.src = speaker.Photo || './pictures/default.jpg';
                                    photo.alt = speaker.Name;

                                    const info = document.createElement('div');
                                    info.className = 'speaker-info';

                                    const name = document.createElement('div');
                                    name.className = 'speaker-name';
                                    name.textContent = speaker.Name;

                                    const linkedIn = document.createElement('a');
                                    linkedIn.href = speaker.Social.LinkedIn;
                                    linkedIn.target = '_blank';
                                    linkedIn.textContent = 'LinkedIn';

                                    info.appendChild(name);
                                    info.appendChild(linkedIn);
                                    speakerCard.appendChild(photo);
                                    speakerCard.appendChild(info);
                                    speakerContainer.appendChild(speakerCard);
                                }
                            });

                            details.appendChild(speakerContainer);
                            sessionDiv.appendChild(details);
                            daySection.appendChild(sessionDiv);
                        });

                        agendaContainer.appendChild(daySection);
                    });
                })
                .catch(error => console.error('Error loading speakers:', error));
        })
        .catch(error => console.error('Error loading agenda:', error));
});