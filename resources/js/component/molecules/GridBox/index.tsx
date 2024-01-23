import React from 'react';
import { Col, Row } from 'react-bootstrap';
import { GridBoxProps } from '../../../props/props';
import GridSimple from '../GridSimple';

const GridBox: React.FC<React.PropsWithChildren<GridBoxProps>> = (
  props: GridBoxProps,
): JSX.Element => <GridSimple lable={props.lable}>{props.children}</GridSimple>;
export default GridBox;
