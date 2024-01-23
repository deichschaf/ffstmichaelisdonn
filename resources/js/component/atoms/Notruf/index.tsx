import React, { useEffect, useState } from 'react';
import { NotrufProps } from '../../../props/props';
import ErrorBoundary from '../../organisms/errorboundary';
import PhoneNumber from '../PhoneNumber';
import SVGIcon from '../SVGIcon';

const Notruf: React.FC<React.PropsWithChildren<NotrufProps>> = (
  props: NotrufProps,
): JSX.Element => (
  <ErrorBoundary>
    <h4 className="headline">Notruf</h4>
    <PhoneNumber telephonenumber="112">
      <SVGIcon svg="SignRescueNumber" alt="Notruf 112" />
    </PhoneNumber>
  </ErrorBoundary>
);
export default Notruf;
