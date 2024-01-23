import React from 'react';
import { PhoneNumberProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';

const PhoneNumber: React.FC<React.PropsWithChildren<PhoneNumberProps>> = (
  props: PhoneNumberProps,
): JSX.Element => {
  function makeNumber(number) {
    let n = number.replace(/[/|\-| ]/g, '');
    if (n.substring(0, 1) === 0 || n.substring(0, 1) === '0') {
      n = `+49${n.substring(1)}`;
    }
    return n;
  }
  return (
    <ErrorBoundary>
      <a href={`tel:${makeNumber(props.telephonenumber)}`}>{props.children}</a>
    </ErrorBoundary>
  );
};
export default PhoneNumber;
