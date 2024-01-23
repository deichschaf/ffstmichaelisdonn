const path = '/fileadmin/danceball/';
const year = new Date().setFullYear(new Date().getFullYear() + 1);
export const StorybookData = {
  picture: 'feuerwehrball_2023-large.jpg',
  images: [
    {
      image: 'feuerwehrball_2023-large.jpg',
      type: 'jpg',
      media: '(min-width: 641px)',
    },
    {
      image: 'feuerwehrball_2023-large.png',
      type: 'png',
      media: '(min-width: 641px)',
    },
    {
      image: 'feuerwehrball_2023-large.webp',
      type: 'webp',
      media: '(min-width: 641px)',
    },
    {
      image: 'feuerwehrball_2023-medium.jpg',
      type: 'jpg',
      media: '(min-width: 321px)',
    },
    {
      image: 'feuerwehrball_2023-medium.png',
      type: 'png',
      media: '(min-width: 321px)',
    },
    {
      image: 'feuerwehrball_2023-medium.webp',
      type: 'webp',
      media: '(min-width: 321px)',
    },
    {
      image: 'feuerwehrball_2023-small.jpg',
      type: 'jpg',
      media: '(max-width: 320px)',
    },
    {
      image: 'feuerwehrball_2023-small.png',
      type: 'png',
      media: '(max-width: 320px)',
    },
    {
      image: 'feuerwehrball_2023-small.webp',
      type: 'webp',
      media: '(max-width: 320px)',
    },
  ],
  path,
  text: 'Feuerwehrball',
  content:
    'Am 11. Februar findet der legendäre Feuerwehrball der Freiwilligen Feuerwehr Sankt Michaelisdonn im „Suhr’s Hotel“ in Eddelak statt. Beginn ist um 20 Uhr. Für die Stimmung sorgt die Band "Ralf Wittrock".',
  href: `${path}feuerwehrball_2023.pdf`,
  linktext: 'Flyer',
  target: '_blank',
  icon: 'file-pdf',
  size: '1.2 MB',
  date: '',
  datetime: `${year}-02-11T20:00:00` as string,
  showuntil: `${year}-02-13T00:00:00` as string,
};
