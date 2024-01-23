import React from 'react';
import { IconSetProps } from '../../../../props/props';
import FAS from '../FAS';

const AlcoholIcon: React.FC<React.PropsWithChildren<IconSetProps>> = (
  props: IconSetProps,
): JSX.Element => <FAS className="wine-bottle" title={props.title} />;
export default AlcoholIcon;
