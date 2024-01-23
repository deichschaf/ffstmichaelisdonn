import React from 'react';
import { CountUpWithIconProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import FA from '../Icon/FA';
import FAB from '../Icon/FAB';
import FAD from '../Icon/FAD';
import FAL from '../Icon/FAL';
import FAR from '../Icon/FAR';
import FAS from '../Icon/FAS';
import H3 from '../Typography/H3';
import P from '../Typography/P';

const CountUpWithIcon: React.FC<React.PropsWithChildren<CountUpWithIconProps>> = (
  props: CountUpWithIconProps,
): JSX.Element => {
  if (typeof props.maxcount === 'undefined') {
    return <></>;
  }

  function getIcon(icontype, icon) {
    if (icontype === 'fas') {
      return <FAS className={icon} />;
    }
    if (icontype === 'fa') {
      return <FA className={icon} />;
    }
    if (icontype === 'fab') {
      return <FAB className={icon} />;
    }
    if (icontype === 'fad') {
      return <FAD className={icon} />;
    }
    if (icontype === 'fal') {
      return <FAL className={icon} />;
    }
    if (icontype === 'far') {
      return <FAR className={icon} />;
    }
    return <></>;
  }

  let counter = props.startcount as number;
  const maxcount = props.maxcount as number;

  function updateCounter() {
    if (counter < maxcount) {
      counter += 1;
    }
  }
  setTimeout(updateCounter, 1300);

  return (
    <ErrorBoundary>
      <div className="count_up">
        {getIcon(props.icontype, props.icon)}
        <H3 id={props.id}>{counter}</H3>
        <P>{props.description}</P>
      </div>
    </ErrorBoundary>
  );
};
export default CountUpWithIcon;
