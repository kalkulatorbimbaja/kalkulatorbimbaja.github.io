// Funkcja do tworzenia chmury z opisem skilla
function createTooltip(skillName, description, parent) {
  const tooltip = document.createElement('div');
  tooltip.classList.add('tooltip');
  tooltip.textContent = description;

  // Ustawienie pozycji chmury względem check boxa
  tooltip.style.top = (parent.offsetTop + parent.offsetHeight + 5) + 'px';
  tooltip.style.left = parent.offsetLeft + 'px';

  // Dodanie chmury do ciała dokumentu
  document.body.appendChild(tooltip);

  // Usunięcie chmury po zakończeniu najechania kursorem na nazwę skilla
  parent.addEventListener('mouseleave', () => {
    if (tooltip.parentNode === document.body) {
      document.body.removeChild(tooltip);
    }
  });
}

// Funkcja do wyświetlania opisu skilla
function displaySkillDescription(skillName, parent, data) {
  const skill = data.skills.find(skill => skill.name === skillName);
  if (skill) {
    createTooltip(skillName, skill.description, parent);
  }
}

// Funkcja do wyświetlania listy skilli
function displaySkillsList(data) {
  const skillsList = document.getElementById('skills-list');
  skillsList.innerHTML = ''; // Wyczyszczenie listy przed wygenerowaniem nowej
  data.skills.forEach(skill => {
    const listItem = document.createElement('div');
    listItem.classList.add('skill-item');
    const checkbox = document.createElement('input');
    checkbox.type = 'checkbox';
    checkbox.name = skill.name;
    checkbox.id = skill.name.replace(/\s+/g, '-').toLowerCase();
    const label = document.createElement('label');
    label.textContent = skill.name;
    label.htmlFor = checkbox.id;
    label.addEventListener('mouseenter', () => displaySkillDescription(skill.name, listItem, data));
    listItem.appendChild(label);
    listItem.appendChild(checkbox);
    skillsList.appendChild(listItem);
  });
}

// Funkcja do wyświetlania obrazka dla wybranej pozycji
function displayPositionImage(positionName) {
  const positionImg = document.getElementById('position-img');
  positionImg.src = `images/${positionName.toLowerCase()}.png`; // Załadowanie odpowiedniego obrazka z katalogu images
  positionImg.alt = `${positionName} Image`; // Ustawienie tekstu alternatywnego
}

// Funkcja do wyświetlania propozycji skilli
function displayRecommendedSkills(data) {
  const recommendedSkillsList = document.getElementById('recommended-skills-list');
  recommendedSkillsList.innerHTML = ''; // Wyczyszczenie listy przed wygenerowaniem nowej

  const selectedPosition = document.getElementById('positions-list').value;
  
  // Sprawdzenie, czy istnieje właściwość position_weights w obiekcie data
  if (data && data.position_weights) {
    const selectedPositionSkills = data.position_weights[selectedPosition];

    // Utworzenie kopii skilli
    const availableSkills = [...data.skills];

    // Usunięcie już zaznaczonych skilli
    const checkedSkills = document.querySelectorAll('#skills-list input:checked');
    checkedSkills.forEach(checkedSkill => {
      const index = availableSkills.findIndex(skill => skill.name === checkedSkill.name);
      if (index !== -1) {
        availableSkills.splice(index, 1);
      }
    });

	// Posortowanie skilli według wagi niezerowej, a następnie alfabetycznie
	availableSkills.sort((a, b) => {
	  const weightA = selectedPositionSkills[a.name] || 0;
	  const weightB = selectedPositionSkills[b.name] || 0;
	  
	  // Odfiltrowanie skilli z wagą równą 0
	  if (weightA === 0 && weightB === 0) {
		return 0; // Jeśli obie wagi są zerowe, zwracamy 0, aby zachować pierwotną kolejność
	  } else if (weightA === 0) {
		return 1; // Przesuń skill B z wagą 0 na dół
	  } else if (weightB === 0) {
		return -1; // Przesuń skill A z wagą 0 na dół
	  } else {
		// Jeśli obie wagi są niezerowe, sortujemy według wagi, a jeśli wagi są równe, sortujemy alfabetycznie
		if (weightA !== weightB) {
		  return weightB - weightA;
		} else {
		  return a.name.localeCompare(b.name);
		}
	  }
	});


    // Dodanie propozycji do listy
    availableSkills.slice(0, 5).forEach(skill => {
      const listItem = document.createElement('div');
      listItem.classList.add('recommended-skill-item');
      listItem.textContent = skill.name;
      recommendedSkillsList.appendChild(listItem);
    });
  }
}

function fetchSkillsAndDisplayRecommended() {
  fetch('skills.json')
    .then(response => response.json())
    .then(data => {
      displayRecommendedSkills(data);
    })
    .catch(error => console.error('Error fetching JSON:', error));
}

document.addEventListener('DOMContentLoaded', () => {
  // Wygenerowanie listy dostępnych pozycji
  const positionsList = document.getElementById('positions-list');
  fetch('skills.json')
    .then(response => response.json())
    .then(data => {
      for (const position in data.position_weights) {
        const option = document.createElement('option');
        option.value = position;
        option.textContent = position;
        positionsList.appendChild(option);
      }

      // Obsługa zmiany wybranej pozycji
      positionsList.addEventListener('change', () => {
        const selectedPosition = positionsList.value;
        displayPositionImage(selectedPosition);
        //displayRecommendedSkills(data); // Odświeżenie propozycji skilli po zmianie pozycji
      });

      // Wyświetlenie obrazka dla domyślnej pozycji
      const defaultPosition = positionsList.value;
      displayPositionImage(defaultPosition);

      // Wywołanie funkcji do wyświetlania listy skilli przy załadowaniu strony
      displaySkillsList(data);
    })
    .catch(error => console.error('Error fetching JSON:', error));
});
