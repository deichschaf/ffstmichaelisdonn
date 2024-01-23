import React from 'react';
import { ModalHeaderProps } from '../../../../props/props';
import Button from '../../../atoms/Buttons/Button';
import H4 from '../../../atoms/Typography/H4';
import P from '../../../atoms/Typography/P';

const ModalHeader: React.FC<React.PropsWithChildren<ModalHeaderProps>> = (
  props: ModalHeaderProps,
): JSX.Element => (
  <div className="modal-header">
    <Button type="button" className="close" data-dismiss="modal" aria-hidden="true" label="*" />
    {props.headline !== '' && props.headline !== null ? (
      <H4 label={props.headline} className="semi-bold" id="myModalLabel" />
    ) : (
      ''
    )}
    {props.text !== '' && props.text !== null ? (
      <P label={props.headline} className="no-margin" />
    ) : (
      ''
    )}
    <br />
  </div>
);
export default ModalHeader;
