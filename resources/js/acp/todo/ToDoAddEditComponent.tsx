import React, { useEffect, useState } from 'react';
import { Col, Row } from 'react-bootstrap';
import { useParams } from 'react-router';
import Select from 'react-select';
import Input from '../../component/atoms/Form/Input/Input';
import Textarea from '../../component/atoms/Form/Textarea';
import PageHeadline from '../../component/atoms/PageHeadline';
import { getCookie, getCSRFToken } from '../../component/component_helper';
import GridSimple from '../../component/molecules/GridSimple';
import LoadingAlertBox from '../../component/molecules/LoadingAlertBox';
import SaveInfoError from '../../component/molecules/SaveInfoError';
import SaveLine from '../../component/molecules/SaveLine';
import ErrorBoundary from '../../component/organisms/errorboundary';
import { ToDoAddEditProps } from '../../props/props';

const ToDoAddEditComponent: React.FC<React.PropsWithChildren<ToDoAddEditProps>> = (
  props: ToDoAddEditProps,
): JSX.Element => {
  const [loading, setLoading] = useState(true);
  const [getEditType, setEditType] = useState<string>('hinzufügen');
  const [selectValues, setSelectValues] = useState<any>(null);
  const [errorText, setErrorText] = useState<any>(null);
  const [responseText, setResponseText] = useState<any>(null);
  const [getId, setId] = useState<number>(0);
  const [getTitle, setTitle] = useState<string>('');
  const [getDescription, setDescription] = useState<string>('');
  const [getAreaId, setAreaId] = useState<number>(1);
  const [getStatusId, setStatusId] = useState<number>(1);
  const [getTypeId, setTypeId] = useState<number>(1);

  const { id } = useParams();

  function CheckResponse(data) {
    if (data.success === true) {
      setResponseText('Erfolgreich gespeichert!');
    } else {
      setErrorText(data.errorMessage);
    }
  }

  function setCatchError(err) {
    setErrorText(err);
  }

  function setDefaultData(data) {
    setId(data.id);
    setTitle(data.title);
    setDescription(data.description);
    setAreaId(data.area_id);
    setStatusId(data.status_id);
    setTypeId(data.type_id);
  }

  function onChangeAreaId(e) {
    setAreaId(e.value);
  }

  function onChangeStatusId(e) {
    setStatusId(e.value);
  }

  function onChangeTypeId(e) {
    setTypeId(e.value);
  }

  function setSelectedValue(id, options) {
    for (let i = 0; i < options.length; i += 1) {
      if (options[i].id === id) {
        return { label: options[i].label, value: options[i].value };
      }
    }
    return { label: '', value: '' };
  }

  const SubmitForm = event => {
    event.preventDefault();
    setErrorText(null);
    setResponseText(null);
    const token = getCSRFToken();
    // console.log(token);
    const csrfToken = getCookie('XSRF-TOKEN');
    let headers = new Headers({
      'Content-Type': 'application/json',
    });
    if (csrfToken !== null) {
      headers = new Headers({
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
      });
    }
    fetch('/api/admin/todo/save', {
      method: 'POST',
      headers,
      body: JSON.stringify({
        id: getId,
        title: getTitle,
        description: getDescription,
        area_id: getAreaId,
        status_id: getStatusId,
        type_id: getTypeId,
        'csrf-token': token,
        _token: token,
      }),
    })
      .then(response => response.json())
      .then(data => CheckResponse(data))
      .catch(err => setCatchError(err));
  };

  useEffect(() => {
    async function fetchMyApi() {
      let response = await fetch(`/api/admin/todo/data/${id}`);
      response = await response.json();
      setLoading(false);
      setDefaultData(response);
    }

    async function getSelects() {
      let response = await fetch('/api/admin/todo/todoselects');
      response = await response.json();
      setSelectValues(response);
    }

    getSelects();
    if (id !== undefined) {
      setEditType('bearbeiten');
      fetchMyApi();
    } else {
      setLoading(false);
    }
  }, [id]);

  if (loading || selectValues === null) {
    return <LoadingAlertBox />;
  }
  return (
    <div className="container">
      <div className="overview_headline">
        <ErrorBoundary>
          <SaveInfoError responseText={responseText} errorText={errorText} />
        </ErrorBoundary>
        <ErrorBoundary>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <PageHeadline label={`Admin - ToDo ${getEditType}`} />
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Titel:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Input
                        defaultValue={getTitle}
                        name="title"
                        placeholder=""
                        className="form-control"
                        onChange={e => setTitle(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={12} xl={12} lg={12} md={12} sm={12} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Beschreibung:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Textarea
                        defaultValue={getDescription}
                        name="tododescription"
                        placeholder=""
                        className="form-control"
                        onChange={e => setDescription(e.target.value)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <Row>
            <Col xxl={4} xl={4} lg={4} md={6} sm={6} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Bereich:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Select
                        name="bereich"
                        defaultValue={setSelectedValue(getAreaId, selectValues.todo_area)}
                        options={selectValues.todo_area}
                        className="basic-multi-select"
                        onChange={e => onChangeAreaId(e)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={4} xl={4} lg={4} md={6} sm={6} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Status:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Select
                        name="status"
                        defaultValue={setSelectedValue(getStatusId, selectValues.todo_status)}
                        options={selectValues.todo_status}
                        className="basic-multi-select"
                        onChange={e => onChangeStatusId(e)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
            <Col xxl={4} xl={4} lg={4} md={6} sm={6} xs={12}>
              <GridSimple>
                <div className="form-group">
                  <label className="form-label">Typ:</label>
                  <div className="controls">
                    <ErrorBoundary>
                      <Select
                        name="bereich"
                        defaultValue={setSelectedValue(getTypeId, selectValues.todo_type)}
                        options={selectValues.todo_type}
                        className="basic-multi-select"
                        onChange={e => onChangeTypeId(e)}
                      />
                    </ErrorBoundary>
                  </div>
                </div>
              </GridSimple>
            </Col>
          </Row>
          <SaveLine SubmitForm={SubmitForm} backurl="/admin/todo/overview" />
        </ErrorBoundary>
        <ErrorBoundary>
          <SaveInfoError responseText={responseText} errorText={errorText} />
        </ErrorBoundary>
      </div>
    </div>
  );
};

export default ToDoAddEditComponent;
