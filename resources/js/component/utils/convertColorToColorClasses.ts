import Colors from '../types/colors';

const convertColorToColorClasses = (color: Colors) => {
  switch (color) {
    case 'black':
      return 'text-black';
    case 'red':
      return 'text-red';
    case 'gray':
    default:
      return 'text-gray';
  }
};

export default convertColorToColorClasses;
