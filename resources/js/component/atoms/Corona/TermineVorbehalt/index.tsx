import React from 'react';
import { TermineVorbehaltProps } from '../../../../props/props';
import GridBox from '../../../molecules/GridBox';
import ErrorBoundary from '../../../organisms/errorboundary';

const TermineVorbehalt: React.FC<React.PropsWithChildren<TermineVorbehaltProps>> = (
  props: TermineVorbehaltProps,
): JSX.Element => (
  /* if (typeof props.data === "undefined") {
    return <></>;
  } */
  <ErrorBoundary>
    <GridBox lable="Corona-Info">
      Diese Termine stehen unter dem Vorbehalt der weiteren Entwicklung bei der Corona-Pandemie.
    </GridBox>
  </ErrorBoundary>
);
export default TermineVorbehalt;
