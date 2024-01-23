import React from 'react';
import { CoronaTermineProps } from '../../../../props/props';
import GridBox from '../../../molecules/GridBox';
import ErrorBoundary from '../../../organisms/errorboundary';

const CoronaTermine: React.FC<React.PropsWithChildren<CoronaTermineProps>> = (
  props: CoronaTermineProps,
): JSX.Element => (
  /* if (typeof props.data === "undefined") {
    return <></>;
  } */
  <ErrorBoundary>
    <GridBox lable="Corona-Info">
      Wir können den Dienstbetrieb aufnehmen, aber unter strenger Hygiene-vorschrift. Beim Dienst
      sind Masken zu tragen und Hände zu desinfizieren.
      <br />
      Nach dem Dienst Gerätschaften desinfizieren.
      <br />
      Wer sich krank fühlt oder anderweitig verhindert ist, meldet sich bitte ab.
    </GridBox>
  </ErrorBoundary>
);
export default CoronaTermine;
